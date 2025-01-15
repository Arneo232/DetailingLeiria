package com.example.amsi.modelo;

import android.content.Context;
import android.content.SharedPreferences;
import android.util.Log;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.amsi.listeners.LoginListener;
import com.example.amsi.listeners.UtilizadorListener;
import com.example.amsi.utils.LoginJsonParser;
import com.example.amsi.utils.ProdutoJsonParser;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

import com.example.amsi.listeners.ProdutoListener;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.List;

public class SingletonGestorProdutos {
    public Utilizador utilizador;

    private static RequestQueue volleyQueue = null;
    private LoginListener loginListener;
    private static volatile SingletonGestorProdutos instance = null;
    private UtilizadorListener utilizadorListener;
    private Utilizador login;

    public static synchronized SingletonGestorProdutos getInstance(Context context) {
        if (instance == null) {
            instance = new SingletonGestorProdutos();
            volleyQueue = Volley.newRequestQueue(context);
        }
        return instance;
    }

    public String getApiIP(Context context) {
        SharedPreferences preferences = context.getSharedPreferences("api_url", Context.MODE_PRIVATE);
        return preferences.getString("API", null);
    }

    public Utilizador getUtilizador() {
        return utilizador;
    }

    public void setLoginListener(LoginListener loginListener) {
        this.loginListener = loginListener;
    }

    public int getUserId(Context context) {
        SharedPreferences preferences = context.getSharedPreferences("user_prefs", Context.MODE_PRIVATE);
        return preferences.getInt("user_id", 0); // 0 is the default value if the user ID is not found
    }

    public String getUserToken(Context context) {
        SharedPreferences preferences = context.getSharedPreferences("user_prefs", Context.MODE_PRIVATE);
        return preferences.getString("user_token", null);
    }

    public void loginAPI(final String username, final String password, final Context context) {
        final String mUrlAPILogin = "http://172.22.21.201/DetailingLeiria/DtlgLeiWebApp/backend/web/api/auth/login";
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação à internet", Toast.LENGTH_SHORT).show();
        }else{
            StringRequest request = new StringRequest(Request.Method.POST, mUrlAPILogin, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    try {
                        login = LoginJsonParser.parserJsonLogin(response);

                        if(loginListener != null) {
                            loginListener.onValidateLogin(context, login);
                        }
                    } catch (Exception e) {
                        Toast.makeText(context, "Erro: " + e.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, "Erro: " + error.getMessage(), Toast.LENGTH_SHORT).show();
                }
            }) {
                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<>();
                    //params.put("username", username);
                    //params.put("password", password);
                    return params;
                }
                @Override
                public Map<String, String> getHeaders() {
                    Map<String, String> headers = new HashMap<>();
                    String credentials = username + ":" + password;
                    String auth = "Basic " + android.util.Base64.encodeToString(credentials.getBytes(), android.util.Base64.NO_WRAP);
                    headers.put("Authorization", auth);
                    return headers;
                }
            };
            volleyQueue.add(request);
        }
    }

    public void saveUserToken(Context context, String token, String username) {
        SharedPreferences preferences = context.getSharedPreferences("user_prefs", Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = preferences.edit();
        editor.putString("user_token", token);
        editor.putString("username", username);
        editor.apply();
    }

    public void saveUserId(Context context, int userId) {
        SharedPreferences preferences = context.getSharedPreferences("user_prefs", Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = preferences.edit();
        editor.putInt("user_id", userId);
        editor.apply();
    }


    private String mUrlAPIUserData(Context context) {
        return "http://detailingleiria-back.test/api/users/" + getUserId(context) + "?access-token=" + getUserToken(context);
    }


    private ProdutoListener produtoListener;
    private List<Produto> produtos;

    private static final String BASE_URL = "http://detailingleiria-back.test/api";

    public void setProdutoListener(ProdutoListener listener) {
        this.produtoListener = listener;
    }

    // Obter a lista de produtos
    public void getProdutosAPI(final Context context) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        String url = BASE_URL + "/produtos";
        JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, url, null, new Response.Listener<JSONArray>() {
            @Override
            public void onResponse(JSONArray response) {
                produtos = ProdutoJsonParser.parserJsonProdutos(response);
                if (produtoListener != null) {
                    produtoListener.onRefreshListaProdutos(produtos);
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(context, "Erro ao obter produtos: " + error.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
        volleyQueue.add(request);
    }

    // Adicionar produto
    public void adicionarProdutoAPI(final Produto produto, final Context context) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        String url = BASE_URL + "/produtos";
        JSONObject produtoJson = new JSONObject();
        try {
            produtoJson.put("nome", produto.getNome());
            produtoJson.put("preco", produto.getPreco());
            produtoJson.put("descricao", produto.getDescricao());
        } catch (JSONException e) {
            e.printStackTrace();
        }

        JsonObjectRequest request = new JsonObjectRequest(Request.Method.POST, url, produtoJson, new Response.Listener<JSONObject>() {
            @Override
            public void onResponse(JSONObject response) {
                Toast.makeText(context, "Produto adicionado com sucesso!", Toast.LENGTH_SHORT).show();
                getProdutosAPI(context); // Atualizar lista
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(context, "Erro ao adicionar produto: " + error.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
        volleyQueue.add(request);
    }

    // Atualizar produto
    public void atualizarProdutoAPI(final Produto produto, final Context context) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        String url = BASE_URL + "/produtos/" + produto.getId();
        JSONObject produtoJson = new JSONObject();
        try {
            produtoJson.put("nome", produto.getNome());
            produtoJson.put("preco", produto.getPreco());
            produtoJson.put("descricao", produto.getDescricao());
        } catch (JSONException e) {
            e.printStackTrace();
        }

        JsonObjectRequest request = new JsonObjectRequest(Request.Method.PUT, url, produtoJson, new Response.Listener<JSONObject>() {
            @Override
            public void onResponse(JSONObject response) {
                Toast.makeText(context, "Produto atualizado com sucesso!", Toast.LENGTH_SHORT).show();
                getProdutosAPI(context); // Atualizar lista
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(context, "Erro ao atualizar produto: " + error.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
        volleyQueue.add(request);
    }

    // Remover produto
    public void removerProdutoAPI(final int produtoId, final Context context) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        String url = BASE_URL + "/produtos/" + produtoId;
        StringRequest request = new StringRequest(Request.Method.DELETE, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                Toast.makeText(context, "Produto removido com sucesso!", Toast.LENGTH_SHORT).show();
                getProdutosAPI(context); // Atualizar lista
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(context, "Erro ao remover produto: " + error.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
        volleyQueue.add(request);
    }

}
