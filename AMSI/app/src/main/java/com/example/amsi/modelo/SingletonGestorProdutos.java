package com.example.amsi.modelo;

import android.app.DownloadManager;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.net.Uri;
import android.os.Environment;
import android.util.Log;
import android.widget.Toast;

import androidx.core.content.FileProvider;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.HttpHeaderParser;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.amsi.EditarDadosActivity;
import com.example.amsi.listeners.AvaliacoesListener;
import com.example.amsi.listeners.CarrinhoListener;
import com.example.amsi.listeners.CarrinhosListener;
import com.example.amsi.listeners.FaturaListener;
import com.example.amsi.listeners.FaturasListener;
import com.example.amsi.listeners.FavoritosListener;
import com.example.amsi.listeners.LoginListener;
import com.example.amsi.listeners.MetodoEntregaListener;
import com.example.amsi.listeners.MetodoPagamentoListener;
import com.example.amsi.listeners.ProdutosListener;
import com.example.amsi.listeners.ProdutoListener;
import com.example.amsi.listeners.RegisterListener;
import com.example.amsi.listeners.UtilizadorListener;
import com.example.amsi.listeners.VerificaFavoritoListener;
import com.example.amsi.utils.AvaliacaoJsonParser;
import com.example.amsi.utils.FaturaJsonParser;
import com.example.amsi.utils.FavoritoJsonParser;
import com.example.amsi.utils.LinhasCarrinhoJsonParser;
import com.example.amsi.utils.LinhasFaturaJsonParser;
import com.example.amsi.utils.LoginJsonParser;
import com.example.amsi.utils.ProdutoJsonParser;
import com.example.amsi.utils.RegisterJsonParser;
import com.example.amsi.utils.UtilizadorJsonParser;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;
import java.util.List;

public class SingletonGestorProdutos {
    public Utilizador utilizador;

    private static RequestQueue volleyQueue = null;
    private static volatile SingletonGestorProdutos instance = null;
    private Utilizador login;
    private FavoritoBDHelper favoritoBDHelper;

    private LoginListener loginListener;
    private RegisterListener registerListener;
    private UtilizadorListener utilizadorListener;
    private ProdutosListener produtosListener;
    private ProdutoListener produtoListener;
    private FavoritosListener favoritosListener;
    private VerificaFavoritoListener verificafavoritoListener;
    private FaturasListener faturasListener;
    private FaturaListener faturaListener;
    private AvaliacoesListener avaliacoesListener;
    private CarrinhosListener carrinhosListener;
    private CarrinhoListener carrinhoListener;
    private MetodoEntregaListener metodoEntregaListener;
    private MetodoPagamentoListener metodoPagamentoListener;

    private static String mUrlAPIProdutos = "" ;
    private static String mUrlAPIProduto = "" ;
    private static String mUrlAPILogin = "";
    private static String mUrlAPIRegister = "";
    private static String mUrlAPICarrinho ="";
    private static String mUrlAPILinhasCarrinho ="";
    private static String mUrlAPIAddCarrinho ="";
    private static String mUrlAPIRemoverCarrinho ="";
    private static String mUrlAPIAumentarQuantidade = "";
    private static String mUrlAPIDiminuirQuantidade = "";
    private static String mUrlAPIFinalizarCompra ="";
    private static String mUrlAPIPagamento ="";
    private static String mUrlAPIEntrega ="";
    private static String mUrlAPIFaturas ="";
    private static String mUrlAPIFatura ="";
    private static String mUrlAPIDownloadFatura ="";
    private static String mUrlAPIAvaliacoes = "";
    private static String mUrlAPIAddAvaliacao = "";
    private static String mUrlAPIRemoverAvaliacao = "";
    private static String mUrlAPIFavorito="";
    private static String mUrlAPIFavoritoVerifica ="";
    private static String mUrlAPIFavoritoRemover="";
    private static String mUrlAPIFavoritoAdicionar="";
    private static String mUrlAPIProfile="";
    private static String mUrlAPIProfileEditar="";

    public static synchronized SingletonGestorProdutos getInstance(Context context) {
        if (instance == null) {
            instance = new SingletonGestorProdutos(context);
            volleyQueue = Volley.newRequestQueue(context);
        }
        return instance;
    }

    private SingletonGestorProdutos(Context context) {
        favoritoBDHelper = new FavoritoBDHelper(context);
    }

    public void setIpAddress(String ipAddress, Context context) {

        mUrlAPIProdutos = "http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/produtos/todosprodutos";
        mUrlAPIProduto = "http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/produtos";
        mUrlAPILogin = "http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/auth/login";
        mUrlAPIRegister = "http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/auth/register";
        mUrlAPICarrinho ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/carrinhos";
        mUrlAPILinhasCarrinho ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/carrinhos";
        mUrlAPIAddCarrinho ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/linhas-carrinho/addlinha";
        mUrlAPIRemoverCarrinho ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/linhas-carrinho/removerlinha";
        mUrlAPIAumentarQuantidade = "http://" + ipAddress + "/DetailingLeiria/DtlgLeiWebApp/backend/web/api/linhas-carrinho/aumentarlinha";
        mUrlAPIDiminuirQuantidade = "http://" + ipAddress + "/DetailingLeiria/DtlgLeiWebApp/backend/web/api/linhas-carrinho/diminuirlinha";
        mUrlAPIFinalizarCompra ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/venda/finalizarcompra";
        mUrlAPIFaturas ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/vendas/vendasporperfil";
        mUrlAPIFatura ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/vendas/vendasporperfil";
        mUrlAPIDownloadFatura ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/vendas/vendapdf";
        mUrlAPIAvaliacoes = "http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/avaliacaos/avaliacoesporproduto";
        mUrlAPIAddAvaliacao = "http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/avaliacaos/fazeravaliacao";
        mUrlAPIRemoverAvaliacao = "http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/avaliacaos/delavaliacaoporid";
        mUrlAPIFavorito ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/favoritos";
        mUrlAPIFavoritoVerifica ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/favoritos/verificafav";
        mUrlAPIFavoritoRemover ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/favorito/removefav";
        mUrlAPIFavoritoAdicionar ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/favorito/addfav";
        mUrlAPIPagamento ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/metodopagamento";
        mUrlAPIEntrega ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/metodoentrega";
        mUrlAPIProfile ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/profiles/perfil";
        mUrlAPIProfileEditar ="http://"+ ipAddress +"/DetailingLeiria/DtlgLeiWebApp/backend/web/api/profiles/editperfil";

    }

    public void setProdutosListener(ProdutosListener produtosListener) {
        this.produtosListener = produtosListener;
    }

    public void setProdutoListener(ProdutoListener produtoListener) {
        this.produtoListener = produtoListener;
    }

    public void setLoginListener(LoginListener loginListener) {
        this.loginListener = loginListener;
    }

    public void setRegisterListener(RegisterListener registerListener) {
        this.registerListener = registerListener;
    }

    public void setFavoritosListener(FavoritosListener favoritosListener) {
        this.favoritosListener = favoritosListener;
    }

    public void setVerificaFavoritoListener(VerificaFavoritoListener verificafavoritoListener){
        this.verificafavoritoListener = verificafavoritoListener;
    }

    public void setFaturasListener(FaturasListener faturasListener) {
        this.faturasListener = faturasListener;
    }

    public void setFaturaListener(FaturaListener faturaListener) {
        this.faturaListener = faturaListener;
    }

    public void setCarrinhosListener(CarrinhosListener carrinhosListener) {
        this.carrinhosListener = carrinhosListener;
    }

    public void setCarrinhoListener(CarrinhoListener carrinhoListener) {
        this.carrinhoListener = carrinhoListener;
    }

    public void setAvaliacoesListener(AvaliacoesListener avaliacoesListener){
        this.avaliacoesListener = avaliacoesListener;
    }

    public void setUtilizadorListener(UtilizadorListener utilizadorListener){
        this.utilizadorListener = utilizadorListener;
    }

    public Utilizador getUtilizador() {
        return utilizador;
    }
    public void setUtilizador(Utilizador utilizador) {
        this.utilizador = utilizador;
    }

    public ArrayList<Favorito> getFavoritoBD(Context context) {
        Log.e("SingletonGestorProdutos", "getFavoritoBD called");
        return favoritoBDHelper.getFavoritosBD(context);
    }

    public void loginAPI(final String username, final String password, final Context context) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            StringRequest request = new StringRequest(Request.Method.POST, mUrlAPILogin, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    try {
                        JSONObject jsonObject = new JSONObject(response);

                        login = LoginJsonParser.parserJsonLogin(response);

                        SharedPreferences sharedPreferences = context.getSharedPreferences("DADOS_USER", Context.MODE_PRIVATE);
                        SharedPreferences.Editor editor = sharedPreferences.edit();
                        editor.putString("token", jsonObject.getString("token"));
                        editor.putString("idprofile", jsonObject.getString("idprofile"));
                        editor.putInt("id", jsonObject.getInt("id"));
                        editor.apply();

                        String savedIdProfile = sharedPreferences.getString("idprofile", "NOT FOUND");
                        Log.d("SharedPreferences", "idprofile saved: " + savedIdProfile);

                        if (loginListener != null) {
                            loginListener.onValidateLogin(context, login);
                        }
                    } catch (Exception e) {
                        Toast.makeText(context, "Erro: " + e.getMessage(), Toast.LENGTH_SHORT).show();
                        Log.e("LoginAPI", "Error parsing response: " + e.getMessage());
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, "Erro: " + error.getMessage(), Toast.LENGTH_SHORT).show();
                    Log.e("LoginAPI", "Volley Error: " + error.getMessage());
                }
            }) {
                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<>();
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

    public void registerAPI(Utilizador utilizador, final Context context) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            StringRequest stringRequest = new StringRequest(Request.Method.POST, mUrlAPIRegister,
                    response -> {

                        Log.e("RegisterAPIResponse", "Response: " + response);

                        String message = RegisterJsonParser.parserJsonRegister(response);
                        Log.e("ParsedMessage", "Message: '" + message + "'");

                        if (message != null) {
                            Log.e("ParsedMessage", "Message length: " + message.length());
                        }
                        Log.e("RegisterAPI", "Message before check: '" + message + "'");
                        if (message != null && !message.trim().isEmpty()) {
                            Log.e("RegisterAPI", "Message passed the check: '" + message + "'");
                            registerListener.onSignup(message);
                        } else {
                            Log.e("RegisterAPI", "Message was null or empty");
                            Toast.makeText(context, "Erro ao registrar", Toast.LENGTH_SHORT).show();
                        }
                    },
                    error -> {
                        String errorMsg = error.getMessage();
                        if (error.networkResponse != null) {
                            errorMsg = "Error Code: " + error.networkResponse.statusCode + "\n" +
                                    "Response: " + new String(error.networkResponse.data);
                        }
                        Toast.makeText(context, "Erro 2: " + errorMsg, Toast.LENGTH_LONG).show();
                        Log.e("RegisterError", errorMsg, error);
                    }) {
                @Override
                public Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<>();
                    params.put("username", utilizador.getUsername());
                    params.put("password", utilizador.getPassword());
                    params.put("email", utilizador.getEmail());
                    params.put("morada", utilizador.getMorada());
                    params.put("ntelefone", utilizador.getNtelefone());
                    return params;
                }
            };
            volleyQueue.add(stringRequest);
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

    public void getAllFavoritosAPI(final Context context) {
        Log.d("API", "getAllFavoritosAPI chamado");

        SharedPreferences sp = context.getSharedPreferences("DADOSUSER", Context.MODE_PRIVATE);
        int idp = sp.getInt("idprofile", login.getIdprofile());

        Log.d("API", "Buscar os favoritos para o idprofile: " + idp);

        StringRequest request = new StringRequest(Request.Method.GET, mUrlAPIFavorito + '/' + idp + "?token=" + login.token,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.d("API", "Response received: " + response);
                        try {
                            ArrayList<Favorito> favoritos = FavoritoJsonParser.parserJsonFavoritos(response);
                            Log.d("API", "Favoritos totais: " + favoritos.size());

                            FavoritoBDHelper dbHelper = new FavoritoBDHelper(context);
                            dbHelper.removerTodosFavoritos();
                            Log.d("DB_DELETE", "Remover todos os favoritos na DB");

                            for (Favorito f : favoritos) {
                                dbHelper.adicionarFavorito(f);
                                Log.d("DB_INSERT", "Inserir o Favorito por ID: " + f.getIdfavorito());
                            }
                            if (favoritosListener != null) {
                                favoritosListener.onRefreshFavoritos(favoritos);
                            }
                        } catch (Exception e) {
                            Log.e("API", "Erro a fazer o parsing dos favoritos: " + e.getMessage(), e);
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.e("VolleyError", "Erro a buscar os favoritos: " + error.getMessage(), error);
                    }
                });

        volleyQueue.add(request);
        Log.d("API", "Request adicionada a queue");
    }

    public void verificaFavAPI(final Context context, int idProduto) {
        SharedPreferences sp = context.getSharedPreferences("DADOSUSER", Context.MODE_PRIVATE);
        int idProfile = sp.getInt("idprofile", login.getIdprofile());

        String url = mUrlAPIFavoritoVerifica + "?produto_id=" + idProduto + "&profile_id=" + idProfile + "&token=" + login.token;

        JsonObjectRequest request = new JsonObjectRequest(Request.Method.GET, url, null,
                response -> {
                    try {
                        boolean isFavorito = response.getBoolean("success");
                        if (verificafavoritoListener != null) {
                            verificafavoritoListener.onVerificaFavorito(isFavorito);  // Notify listener
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                        if (verificafavoritoListener != null) {
                            verificafavoritoListener.onVerificaFavorito(false);
                        }
                    }
                },
                error -> {
                    Log.e("VerificaFavError", "Erro ao verificar favorito: " + error.toString());
                    if (verificafavoritoListener != null) {
                        verificafavoritoListener.onVerificaFavorito(false);  // Default to false on error
                    }
                });

        volleyQueue.add(request);
    }


    public void deleteFavoritoAPI(final Context context, final int idFavorito) {
        SharedPreferences sp = context.getSharedPreferences("DADOSUSER", Context.MODE_PRIVATE);
        int idProfile = sp.getInt("idprofile", login.getIdprofile());

        String url = mUrlAPIFavoritoRemover + "?idfavorito=" + idFavorito + "&idprofile=" + idProfile + "&token=" + login.token;

        StringRequest request = new StringRequest(Request.Method.DELETE, url,
                response -> {
                    // Handle the success response
                    Toast.makeText(context, "Favorito removido com sucesso!", Toast.LENGTH_SHORT).show();
                    getAllFavoritosAPI(context); // Refresh the list after deletion
                },
                error -> {
                    // Log error details
                    Log.e("DeleteFavoritoError", "Error: " + error.toString());
                    if (error.networkResponse != null) {
                        Log.e("DeleteFavoritoError", "Status Code: " + error.networkResponse.statusCode);
                        try {
                            String responseBody = new String(error.networkResponse.data, "UTF-8");
                            Log.e("DeleteFavoritoError", "Response: " + responseBody);
                        } catch (Exception e) {
                            e.printStackTrace();
                        }
                    }
                    Toast.makeText(context, "Erro ao remover favorito!", Toast.LENGTH_SHORT).show();
                });

        volleyQueue.add(request);
    }

    public void addFavoritoAPI(final Context context, final int idProduto) {
        SharedPreferences sp = context.getSharedPreferences("DADOSUSER", Context.MODE_PRIVATE);
        int idProfile = sp.getInt("idprofile", login.getIdprofile());

        String url = mUrlAPIFavoritoAdicionar + "?idProfile=" + idProfile + "&idProduto=" + idProduto + "&token=" + login.token;

        StringRequest request = new StringRequest(Request.Method.POST, url,
                response -> {
                    Toast.makeText(context, "Favorito adicionado com sucesso!", Toast.LENGTH_SHORT).show();
                    getAllFavoritosAPI(context);
                },
                error -> {
                    Log.e("AddFavoritoError", "Error: " + error.toString());
                    if (error.networkResponse != null) {
                        Log.e("AddFavoritoError", "Status Code: " + error.networkResponse.statusCode);
                        try {
                            String responseBody = new String(error.networkResponse.data, "UTF-8");
                            Log.e("AddFavoritoError", "Response: " + responseBody);
                        } catch (Exception e) {
                            e.printStackTrace();
                        }
                    }
                    Toast.makeText(context, "Erro ao adicionar favorito!", Toast.LENGTH_SHORT).show();
                }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("idproduto", String.valueOf(idProduto));
                params.put("idprofile", String.valueOf(idProfile));
                params.put("token", login.token);
                return params;
            }
        };


        volleyQueue.add(request);
    }

    public void getAllFaturasAPI(final Context context){
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }
        Log.d("API", "getAllFaturasAPI chamado");

        SharedPreferences sp = context.getSharedPreferences("DADOSUSER", Context.MODE_PRIVATE);
        int idp = sp.getInt("idprofile", login.getIdprofile());

        Log.d("API", "Buscar as faturas para o idprofile: " + idp);

        StringRequest request = new StringRequest(Request.Method.GET, mUrlAPIFaturas + '/' + idp + "?token=" + login.token,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.d("API", "Response received: " + response);
                        try {
                            ArrayList<Fatura> faturas = FaturaJsonParser.parserJsonFaturas(response);
                            Log.d("API", "Faturas totais: " + faturas.size());

                            if (faturasListener != null) {
                                faturasListener.onRefreshFaturas(faturas);
                            }
                        } catch (Exception e) {
                            Log.e("API", "Erro a fazer o parsing dos favoritos: " + e.getMessage(), e);
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.e("VolleyError", "Erro a buscar os favoritos: " + error.getMessage(), error);
                    }
                });

        volleyQueue.add(request);
        Log.d("API", "Request adicionada a queue");
    }

    public void getAllLinhasFaturaAPI(final Context context, final int idFatura) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        SharedPreferences sp = context.getSharedPreferences("DADOSUSER", Context.MODE_PRIVATE);
        int idp = sp.getInt("idprofile", login.getIdprofile());

        Log.d("API", "Buscar as linhas de fatura para idFatura: " + idFatura);

        String url = mUrlAPIFatura + "/" + idp + "?token=" + login.token;

        StringRequest request = new StringRequest(Request.Method.GET, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.d("API", "Response received: " + response);
                        try {
                            ArrayList<LinhasFatura> linhasFatura = LinhasFaturaJsonParser.parserJsonLinhasFatura(response, idFatura);
                            Log.d("API", "Linhas de fatura totais: " + linhasFatura.size());
                            if (faturaListener != null) {
                                faturaListener.onRefreshDetalhes(linhasFatura);
                            }
                        } catch (Exception e) {
                            Log.e("API", "Erro ao fazer parsing das linhas de fatura: " + e.getMessage(), e);
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.e("VolleyError", "Erro ao buscar as linhas de fatura: " + error.getMessage(), error);
                    }
                });

        volleyQueue.add(request);
        Log.d("API", "Request adicionada à queue");
    }

    public void downloadFaturaAPI(final Context context, final int idfatura) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        String url = mUrlAPIDownloadFatura + '/' + idfatura + "?token=" + login.token;

        StringRequest request = new StringRequest(Request.Method.GET, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonResponse = new JSONObject(response);
                            if (jsonResponse.getBoolean("success")) {
                                String downloadUrl = jsonResponse.optString("downloadUrl", "");
                                Log.e("BUG", "Link:" + downloadUrl + "?token=" + login.token);
                                if (!downloadUrl.isEmpty()) {
                                    Intent intent = new Intent(Intent.ACTION_VIEW);
                                    intent.setData(Uri.parse(downloadUrl + "?token=" + login.token));
                                    context.startActivity(intent);
                                } else {
                                    Toast.makeText(context, "Erro ao obter link de download", Toast.LENGTH_SHORT).show();
                                }
                                DownloadManager.Request request = new DownloadManager.Request(Uri.parse(downloadUrl));
                                request.setTitle("Baixando Fatura");
                                request.setDescription("Fatura_" + idfatura + ".pdf");
                                request.setDestinationInExternalPublicDir(Environment.DIRECTORY_DOWNLOADS, "Fatura_" + idfatura + ".pdf");
                                request.setNotificationVisibility(DownloadManager.Request.VISIBILITY_VISIBLE_NOTIFY_COMPLETED);
                                request.setAllowedOverMetered(true);
                                request.setAllowedOverRoaming(true);

                                DownloadManager downloadManager = (DownloadManager) context.getSystemService(Context.DOWNLOAD_SERVICE);
                                if (downloadManager != null) {
                                    downloadManager.enqueue(request);
                                    Toast.makeText(context, "Download iniciado...", Toast.LENGTH_SHORT).show();
                                } else {
                                    Toast.makeText(context, "Erro ao iniciar download", Toast.LENGTH_SHORT).show();
                                }
                            } else {
                                Toast.makeText(context, "Erro: " + jsonResponse.getString("message"), Toast.LENGTH_SHORT).show();
                            }
                        } catch (Exception e) {
                            e.printStackTrace();
                            Toast.makeText(context, "Erro ao processar resposta.", Toast.LENGTH_SHORT).show();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(context, "Erro ao obter URL de download: " + error.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                });

        volleyQueue.add(request);
    }

    public void getCarrinhoAPI(final Context context) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        SharedPreferences sp = context.getSharedPreferences("DADOSUSER", Context.MODE_PRIVATE);
        int idp = sp.getInt("idprofile", login.getIdprofile());

        String url = mUrlAPICarrinho + '/' + idp + "?token=" + login.token;

        StringRequest request = new StringRequest(Request.Method.GET, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.d("API_RESPONSE", "Carrinho API Response: " + response);

                        try {
                            JSONArray outerArray = new JSONArray(response);
                            if (outerArray.length() == 0) {
                                Log.e("API_ERROR", "Outer array is empty!");
                                return;
                            }

                            JSONArray innerArray = outerArray.getJSONArray(0);
                            if (innerArray.length() == 0) {
                                Log.e("API_ERROR", "Inner array is empty!");
                                return;
                            }
                            JSONObject carrinhoObj = innerArray.getJSONObject(0);

                            int idCarrinho = carrinhoObj.getInt("idCarrinho");
                            String total = carrinhoObj.getString("total");
                            SharedPreferences.Editor editor = sp.edit();
                            editor.putInt("idCarrinho", idCarrinho);
                            editor.apply();

                            if (carrinhoListener != null) {
                                carrinhoListener.onCarrinhoLoaded(total, idCarrinho);
                            }
                        } catch (JSONException e) {
                            Log.e("API_ERROR", "Erro ao processar dados do carrinho: " + e.getMessage(), e);
                            Toast.makeText(context, "Erro ao processar dados do carrinho!", Toast.LENGTH_SHORT).show();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.e("API_ERROR", "Erro ao buscar o carrinho: " + error.getMessage(), error);
                        Toast.makeText(context, "Erro ao buscar o carrinho!", Toast.LENGTH_SHORT).show();
                    }
                });

        volleyQueue.add(request);
    }

    public void getAllLinhasCarrinhoAPI(final Context context, final int idCarrinho){
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        SharedPreferences sp = context.getSharedPreferences("DADOSUSER", Context.MODE_PRIVATE);
        int idp = sp.getInt("idprofile", login.getIdprofile());

        String url =  mUrlAPILinhasCarrinho + '/' + idp + "?token=" + login.token;

        StringRequest request = new StringRequest(Request.Method.GET, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.d("API", "Response received: " + response);
                        try {
                            ArrayList<LinhasCarrinho> linhasCarrinho = LinhasCarrinhoJsonParser.parserJsonLinhasCarrinho(response);
                            Log.d("API", "Linhas do carrinho totais: " + linhasCarrinho.size());
                            if (carrinhosListener != null) {
                                carrinhosListener.onRefreshLinhasCarrinho(linhasCarrinho);
                            }
                        } catch (Exception e) {
                            Log.e("API", "Erro ao fazer parsing das linhas do carrinho: " + e.getMessage(), e);
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.e("VolleyError", "Erro ao buscar as linhas do carrinho: " + error.getMessage(), error);
                    }
                });

        volleyQueue.add(request);
        Log.d("API", "Request adicionada à queue");
    }

    public void addLinhaCarrinhoAPI(final Context context, final int idProduto, final int quantidade) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        String url = mUrlAPIAddCarrinho + "?token=" + login.token;

        Map<String, String> params = new HashMap<>();
        params.put("produto_id", String.valueOf(idProduto));
        params.put("quantidade", String.valueOf(quantidade));

        StringRequest request = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonResponse = new JSONObject(response);
                            boolean success = jsonResponse.getBoolean("success");

                            if (success) {
                                Toast.makeText(context, "Produto adicionado ao carrinho com sucesso.", Toast.LENGTH_SHORT).show();
                            } else {
                                String message = jsonResponse.getString("message");
                                Toast.makeText(context, message, Toast.LENGTH_SHORT).show();
                            }
                        } catch (JSONException e) {
                            Log.e("AddCarrinhoAPI", "Error parsing response: " + e.getMessage());
                            Toast.makeText(context, "Erro ao adicionar o produto ao carrinho.", Toast.LENGTH_SHORT).show();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        // Log error details and display error message
                        Log.e("VolleyError", "Error: " + error.toString());
                        if (error.networkResponse != null) {
                            Log.e("VolleyError", "Status Code: " + error.networkResponse.statusCode);
                            try {
                                String responseBody = new String(error.networkResponse.data, "UTF-8");
                                Log.e("VolleyError", "Response: " + responseBody);
                            } catch (Exception e) {
                                e.printStackTrace();
                            }
                        }
                        Toast.makeText(context, "Erro ao adicionar o produto ao carrinho.", Toast.LENGTH_SHORT).show();
                    }
                }) {
            @Override
            protected Map<String, String> getParams() {
                return params;
            }
        };

        // Add the request to the Volley queue
        volleyQueue.add(request);
        Log.d("API", "Request to add product to cart added to queue");
    }

    public void removerLinhaCarrinhoAPI(final Context context, final int idLinhaCarrinho){
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        String url =  mUrlAPIRemoverCarrinho + "?token=" + login.token;

        StringRequest request = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        Log.d("API", "Linha removida com sucesso: " + response);
                        Toast.makeText(context, "Linha removida com sucesso!", Toast.LENGTH_SHORT).show();
                        // Refresh the list if necessary
                        getAllLinhasCarrinhoAPI(context, idLinhaCarrinho);
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.e("API", "Erro ao remover linha: " + error.getMessage());
                        if (error.networkResponse != null) {
                            Log.e("DeleteError", "Status Code: " + error.networkResponse.statusCode);
                            try {
                                String responseBody = new String(error.networkResponse.data, "UTF-8");
                                Log.e("DeleteError", "Response: " + responseBody);
                            } catch (Exception e) {
                                e.printStackTrace();
                            }
                        }
                        Toast.makeText(context, "Erro ao remover linha!", Toast.LENGTH_SHORT).show();
                    }
                }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("idLinhasCarrinho", String.valueOf(idLinhaCarrinho));  // Send the ID in the body
                return params;
            }
        };

        // Add request to the queue
        volleyQueue.add(request);
        Log.d("API", "Request added to queue for deletion");
    }

    public void aumentarQuantidadeAPI(final Context context, int idLinhasCarrinho) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        String url = mUrlAPIAumentarQuantidade + "?token=" + login.token;

        StringRequest request = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonResponse = new JSONObject(response);
                            if (jsonResponse.getBoolean("success")) {
                                Toast.makeText(context, "Quantidade aumentada com sucesso!", Toast.LENGTH_SHORT).show();
                                getCarrinhoAPI(context);
                            } else {
                                Toast.makeText(context, "Erro: " + jsonResponse.getString("message"), Toast.LENGTH_SHORT).show();
                            }
                        } catch (JSONException e) {
                            Toast.makeText(context, "Erro ao processar resposta do servidor!", Toast.LENGTH_SHORT).show();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(context, "Erro ao aumentar quantidade: " + error.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("idLinhasCarrinho", String.valueOf(idLinhasCarrinho));
                return params;
            }
        };
        volleyQueue.add(request);
    }

    public void diminuirQuantidadeAPI(final Context context, int idLinhasCarrinho){
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        String url = mUrlAPIDiminuirQuantidade + "?token=" + login.token;

        StringRequest request = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonResponse = new JSONObject(response);
                            if (jsonResponse.getBoolean("success")) {
                                Toast.makeText(context, "Quantidade diminuida com sucesso!", Toast.LENGTH_SHORT).show();
                                getCarrinhoAPI(context);
                            } else {
                                Toast.makeText(context, "Erro: " + jsonResponse.getString("message"), Toast.LENGTH_SHORT).show();
                            }
                        } catch (JSONException e) {
                            Toast.makeText(context, "Erro ao processar resposta do servidor!", Toast.LENGTH_SHORT).show();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(context, "Erro ao diminuir quantidade: " + error.getMessage(), Toast.LENGTH_SHORT).show();
                    }
                }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("idLinhasCarrinho", String.valueOf(idLinhasCarrinho));
                return params;
            }
        };
        volleyQueue.add(request);
    }

    public void finalizarCompraAPI(final Context context, int idCarrinho, int idMetodoEntrega, int idMetodoPagamento) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        String url =  mUrlAPIFinalizarCompra + "?token=" + login.token;

        JSONObject postData = new JSONObject();
        try {
            postData.put("idCarrinho", idCarrinho);
            postData.put("idMetodoEntrega", idMetodoEntrega);
            postData.put("idMetodoPagamento", idMetodoPagamento);
        } catch (JSONException e) {
            e.printStackTrace();
        }

        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest(Request.Method.POST, url, postData,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            boolean success = response.getBoolean("success");
                            String message = response.getString("message");
                            if (success) {
                                Toast.makeText(context, "Compra finalizada com sucesso!", Toast.LENGTH_SHORT).show();
                            } else {
                                Toast.makeText(context, "Erro: " + message, Toast.LENGTH_SHORT).show();
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                            Toast.makeText(context, "Erro ao processar resposta do servidor", Toast.LENGTH_SHORT).show();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(context, "Erro na requisição: " + error.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
        volleyQueue.add(jsonObjectRequest);
    }

    public void getAllAvaliacoesAPI(final Context context, int idProduto) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        String url = mUrlAPIAvaliacoes + '/' + idProduto + "?token=" + login.token;

        JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, url, null,
                new Response.Listener<JSONArray>() {
                    @Override
                    public void onResponse(JSONArray response) {
                        ArrayList<Avaliacao> listaAvaliacoes = AvaliacaoJsonParser.parseJsonAvaliacoes(response);
                        avaliacoesListener.onRefreshAvaliacoes(listaAvaliacoes);
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(context, "Erro ao carregar avaliações.", Toast.LENGTH_SHORT).show();
                    }
                });

        Volley.newRequestQueue(context).add(request);
    }

    public void fazerAvaliacaoAPI(final Context context, int idProduto, final double rating, final String comentario) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        String url = mUrlAPIAddAvaliacao + "/" + idProduto + "?token=" + login.token;

        StringRequest request = new StringRequest(Request.Method.POST, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonResponse = new JSONObject(response);
                            boolean success = jsonResponse.getBoolean("success");
                            String message = jsonResponse.getString("message");

                            if (success) {
                                Toast.makeText(context, "Avaliação enviada com sucesso.", Toast.LENGTH_SHORT).show();
                            } else {
                                if (message.contains("preciso comprar o produto")) {
                                    Toast.makeText(context, "Erro: Você precisa comprar o produto antes de avaliá-lo.", Toast.LENGTH_LONG).show();
                                } else if (message.contains("Produto não encontrado")) {
                                    Toast.makeText(context, "Erro: Produto não encontrado.", Toast.LENGTH_LONG).show();
                                } else if (message.contains("Invalido ou token em falta")) {
                                    Toast.makeText(context, "Erro: Token inválido ou ausente.", Toast.LENGTH_LONG).show();
                                } else {
                                    Toast.makeText(context, "Erro: " + message, Toast.LENGTH_SHORT).show();
                                }
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                            Toast.makeText(context, "Erro ao processar a resposta do servidor.", Toast.LENGTH_SHORT).show();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(context, "Erro na requisição: " + (error.getMessage() != null ? error.getMessage() : "Erro desconhecido"), Toast.LENGTH_SHORT).show();
                    }
                }) {
            @Override
            protected Map<String, String> getParams() {
                Map<String, String> params = new HashMap<>();
                params.put("rating", String.valueOf(rating));
                params.put("comentario", comentario);
                return params;
            }
        };

        volleyQueue.add(request);
    }

    public void removerAvaliacaoAPI(final Context context, int idAvaliacao, final Response.Listener<String> successListener) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        String url = mUrlAPIRemoverAvaliacao + "/" + idAvaliacao + "?token=" + login.token;

        StringRequest request = new StringRequest(Request.Method.DELETE, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonResponse = new JSONObject(response);
                            boolean success = jsonResponse.getBoolean("success");
                            String message = jsonResponse.getString("message");

                            if (success) {
                                Toast.makeText(context, "Avaliação apagada com sucesso.", Toast.LENGTH_SHORT).show();
                                successListener.onResponse(response);
                            } else {
                                if (message.contains("não tem permissão")) {
                                    Toast.makeText(context, "Erro: Você não tem permissão para apagar esta avaliação.", Toast.LENGTH_LONG).show();
                                } else if (message.contains("Avaliação não encontrada")) {
                                    Toast.makeText(context, "Erro: Avaliação não encontrada.", Toast.LENGTH_LONG).show();
                                } else if (message.contains("token em falta")) {
                                    Toast.makeText(context, "Erro: Token inválido ou ausente.", Toast.LENGTH_LONG).show();
                                } else {
                                    Toast.makeText(context, "Erro: " + message, Toast.LENGTH_SHORT).show();
                                }
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                            Toast.makeText(context, "Erro ao processar a resposta do servidor.", Toast.LENGTH_SHORT).show();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(context, "Erro na requisição: " + (error.getMessage() != null ? error.getMessage() : "Erro desconhecido"), Toast.LENGTH_SHORT).show();
                    }
                });

        volleyQueue.add(request);
    }

    public void getUtilizadorAPI(final Context context) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        SharedPreferences sp = context.getSharedPreferences("DADOSUSER", Context.MODE_PRIVATE);
        int idp = sp.getInt("idprofile", login.getIdprofile());

        String url = mUrlAPIProfile + '/' + idp + "?token=" + login.token;

        StringRequest request = new StringRequest(Request.Method.GET, url, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                try {
                    Utilizador utilizador = UtilizadorJsonParser.parserJsonUtilizador(response);
                    Log.d("RESPONSE", "Response: " + response);
                    SingletonGestorProdutos.getInstance(context).setUtilizador(utilizador);

                    if (utilizadorListener != null) {
                        utilizadorListener.onRefreshUtilizador(utilizador);
                    }

                } catch (Exception e) {
                    Toast.makeText(context, "Erro ao carregar os dados do utilizador: " + e.getMessage(), Toast.LENGTH_LONG).show();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(context, "Erro na API: " + error.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });
        volleyQueue.add(request);
    }

    public void atualizarPerfilAPI(final Context context, final String username, final String email, final String morada, final String ntelefone) {
        // Step 1: Check if there is an internet connection
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        // Step 2: Retrieve the idprofile from SharedPreferences
        SharedPreferences sp = context.getSharedPreferences("DADOSUSER", Context.MODE_PRIVATE);
        int idp = sp.getInt("idprofile", login.getIdprofile());

        // Step 3: Construct the URL
        String url = mUrlAPIProfileEditar + '/' + idp + "?token=" + login.token;

        // Step 4: Prepare the data to send in the request
        // You can either use a JSON object or send form parameters.
        // Using JSONObject for sending JSON data

        JSONObject postData = new JSONObject();
        try {
            postData.put("username", username);
            postData.put("email", email);
            postData.put("morada", morada);
            postData.put("ntelefone", ntelefone);
        } catch (JSONException e) {
            e.printStackTrace();
        }

        // Step 5: Create the POST request
        JsonObjectRequest request = new JsonObjectRequest(Request.Method.POST, url, postData, new Response.Listener<JSONObject>() {
            @Override
            public void onResponse(JSONObject response) {
                try {
                    // Handle the response from the API
                    boolean success = response.getBoolean("success");
                    if (success) {
                        // Profile updated successfully
                        Toast.makeText(context, "Perfil atualizado com sucesso", Toast.LENGTH_SHORT).show();
                    } else {
                        // Handle errors
                        String errorMessage = response.getString("message");
                        Toast.makeText(context, "Erro: " + errorMessage, Toast.LENGTH_LONG).show();
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                    Toast.makeText(context, "Erro ao processar a resposta da API", Toast.LENGTH_SHORT).show();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                // Handle error response from the API
                Toast.makeText(context, "Erro na API: " + error.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });

        // Step 6: Add the request to the Volley request queue
        volleyQueue.add(request);
    }

    public void getMetodosEntregaAPI(final Context context, final MetodoEntregaListener listener) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, mUrlAPIEntrega + "?token=" + login.token, null, new Response.Listener<JSONArray>() {
            @Override
            public void onResponse(JSONArray response) {
                try {
                    // Parse the delivery methods
                    List<MetodoEntrega> metodosEntrega = new ArrayList<>();
                    for (int i = 0; i < response.length(); i++) {
                        JSONObject metodoEntregaJson = response.getJSONObject(i);
                        int id = metodoEntregaJson.getInt("idmetodoEntrega");
                        String designacao = metodoEntregaJson.getString("designacao");

                        MetodoEntrega metodo = new MetodoEntrega(id, designacao);
                        metodosEntrega.add(metodo);
                    }

                    if (listener != null) {
                        listener.onMetodosEntregaObtidos(metodosEntrega);
                    }

                } catch (JSONException e) {
                    Toast.makeText(context, "Erro ao carregar métodos de entrega: " + e.getMessage(), Toast.LENGTH_SHORT).show();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(context, "Erro ao obter métodos de entrega: " + error.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });

        volleyQueue.add(request);
    }

    public void getMetodosPagamentoAPI(final Context context, final MetodoPagamentoListener listener) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Sem ligação à internet", Toast.LENGTH_SHORT).show();
            return;
        }

        JsonArrayRequest request = new JsonArrayRequest(Request.Method.GET, mUrlAPIPagamento + "?token=" + login.token, null, new Response.Listener<JSONArray>() {
            @Override
            public void onResponse(JSONArray response) {
                try {
                    Log.d("API_RESPONSE", "Response: " + response.toString());

                    List<MetodoPagamento> metodosPagamento = new ArrayList<>();
                    for (int i = 0; i < response.length(); i++) {
                        JSONObject metodoPagamentoJson = response.getJSONObject(i);
                        int id = metodoPagamentoJson.getInt("idMetodoPagamento");
                        String designacao = metodoPagamentoJson.getString("designacao");

                        MetodoPagamento metodo = new MetodoPagamento(id, designacao);
                        metodosPagamento.add(metodo);
                    }
                    Log.d("API_RESPONSE", "Payment Methods: " + metodosPagamento.size());
                    if (listener != null) {
                        listener.onMetodosPagamentoObtidos(metodosPagamento);
                    }

                } catch (JSONException e) {
                    Toast.makeText(context, "Erro ao carregar métodos de pagamento: " + e.getMessage(), Toast.LENGTH_SHORT).show();
                }
            }
        }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(context, "Erro ao obter métodos de pagamento: " + error.getMessage(), Toast.LENGTH_SHORT).show();
            }
        });

        volleyQueue.add(request);
    }
}
