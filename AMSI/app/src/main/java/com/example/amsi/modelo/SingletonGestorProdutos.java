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
import com.example.amsi.listeners.ProdutosListener;
import com.example.amsi.listeners.UtilizadorListener;
import com.example.amsi.utils.LoginJsonParser;
import com.example.amsi.utils.ProdutoJsonParser;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
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
    private Utilizador login;
    private ProdutosListener produtosListener;
    private ProdutoListener produtoListener;
    private ArrayList<Produto> listaProdutos;

    private static String mUrlAPIProdutos = "" ;

    private static String mUrlAPIProduto = "" ;

    private static String mUrlAPILogin = "";

    private static String mUrlAPICarrinho ="";

    private static String mUrlAPIFatura ="";

    private static String mUrlAPIFavorito="";

    public static synchronized SingletonGestorProdutos getInstance(Context context) {
        if (instance == null) {
            instance = new SingletonGestorProdutos(context);
            volleyQueue = Volley.newRequestQueue(context);
        }
        return instance;
    }

    private SingletonGestorProdutos(Context context) {
        volleyQueue = Volley.newRequestQueue(context);
        listaProdutos = new ArrayList<>();
    }

    public void setIpAddress(String ipAddress, Context context) {

        mUrlAPIProdutos = "http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/produtos/todosprodutos";
        mUrlAPIProduto = "http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/produtos";
        mUrlAPILogin = "http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/auth/login";
        mUrlAPICarrinho ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/";
        mUrlAPIFatura ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/";
        mUrlAPIFavorito ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/";

    }

    public String getApiIP(Context context) {
        SharedPreferences preferences = context.getSharedPreferences("api_url", Context.MODE_PRIVATE);
        return preferences.getString("API", null);
    }

    public Utilizador getUtilizador() {
        return utilizador;
    }

    public void setProdutosListener(ProdutosListener produtosListener) {
        this.produtosListener = produtosListener;
    }

    public void setLoginListener(LoginListener loginListener) {
        this.loginListener = loginListener;
    }

    public void setProdutoListener(ProdutoListener produtoListener) {
        this.produtoListener = produtoListener;
    }

    public ArrayList<Produto> getProdutosBD() {
        return listaProdutos;
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

    public void getAllProdutosAPI(final Context context) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, mUrlAPIProdutos, null, new Response.Listener<JSONArray>() {
            @Override
            public void onResponse(JSONArray response) {
                try {
                    // Extract the nested JSONArray from the response
                    JSONArray produtosArray = response.getJSONArray(0);

                    // Parse the array using your parser method
                    ArrayList<Produto> produtos = ProdutoJsonParser.parserJsonProdutos(produtosArray, context);

                    if (produtosListener != null) {
                        produtosListener.onRefreshListaProdutos(produtos);
                    }

                } catch (JSONException e) {
                    Toast.makeText(context, "Erro ao carregar produtos: " + e.getMessage(), Toast.LENGTH_SHORT).show();
                    Log.e("Erro:", e.getMessage());
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(context, "Erro ao obter produtos: " + error.getMessage(), Toast.LENGTH_SHORT).show();
                Log.e("VolleyError", error.getMessage());
            }
        });

        volleyQueue.add(request);
    }

    public Produto getProdutoAPI(final Context context, int idProduto) {
        Produto produto = null;
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return produto;
        }

        StringRequest request = new StringRequest(Request.Method.GET, mUrlAPIProduto + "/" + idProduto, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    JSONArray jsonArray = new JSONArray(response);

                    JSONObject jsonObject = jsonArray.getJSONObject(0);

                    Produto produto = ProdutoJsonParser.parserJsonProduto(jsonObject);


                    if (produtoListener != null) {
                        produtoListener.onRefreshDetalhes(produto);
                    }

                } catch (Exception e) {
                    Toast.makeText(context, "Erro ao carregar produtos: " + e.getMessage(), Toast.LENGTH_SHORT).show();
                    Log.e("Erro:", e.getMessage());
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(context, "Erro ao obter produtos: " + error.getMessage(), Toast.LENGTH_SHORT).show();
                Log.e("VolleyError", error.getMessage());
            }
        });

        volleyQueue.add(request);

        return produto;
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
}
