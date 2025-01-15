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

public class SingletonGestorProdutos {
    public Utilizador utilizador;

    private static RequestQueue volleyQueue = null;
    private LoginListener loginListener;
    private static volatile SingletonGestorProdutos instance = null;
    private UtilizadorListener utilizadorListener;
    private Utilizador login;

    public static synchronized SingletonGestorProdutos getInstance(Context context) {
        if (instance == null) {
            synchronized (SingletonGestorProdutos.class) {
                if (instance == null) {
                    instance = new SingletonGestorProdutos();
                    volleyQueue = Volley.newRequestQueue(context);
                }
            }
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
        final String mUrlAPILogin = "http://172.22.21.201/detailingleiria/dtlgleiwebapp/backend/web/api/auth/login";
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação à internet", Toast.LENGTH_SHORT).show();
        }else{
            StringRequest request = new StringRequest(Request.Method.POST, mUrlAPILogin, new Response.Listener<String>(){
                @Override
                public void onResponse(String response){
                    Map<String, String> utilizadorData = LoginJsonParser.parserJsonLogin(response);
                    if(loginListener != null){
                        loginListener.onValidateLogin(context, utilizadorData.get("auth_key"), utilizadorData.get("username"), utilizadorData.get("email"), Integer.parseInt(utilizadorData.get("profile_id")));
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    String errorMessage = "an error occured";
                    if (error.networkResponse != null && error.networkResponse.data != null) {
                        try {
                            String responseBody = new String(error.networkResponse.data, "utf-8");
                        } catch (Exception e) {
                            e.printStackTrace();
                        }
                    }
                    Toast.makeText(context, errorMessage, Toast.LENGTH_LONG).show();
                }
            }) {
                @Override
                public String getBodyContentType(){
                    return "application/x-www-form-urlencoded; charset=UTF-8";
                }
                @Override
                protected Map<String, String> getParams(){
                    Map<String, String> params = new HashMap<>();
                    params.put("username", username);
                    params.put("password", password);
                    return params;
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
}
