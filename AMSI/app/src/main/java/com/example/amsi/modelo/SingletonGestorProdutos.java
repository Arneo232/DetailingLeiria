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
import com.android.volley.toolbox.Volley;
import com.example.amsi.listeners.LoginListener;
import com.example.amsi.listeners.UtilizadorListener;
import com.example.amsi.utils.LoginJsonParser;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

public class SingletonGestorProdutos {
    public Utilizador utilizador, utilizadorData;

    private static RequestQueue volleyQueue = null;
    private LoginListener loginListener;
    private static volatile SingletonGestorProdutos instance = null;
    private UtilizadorListener utilizadorListener;

    public static synchronized SingletonGestorProdutos getInstance(Context context) {
        if (instance == null) {
            synchronized (SingletonGestorProdutos.class) {
                if (instance == null) {
                    instance = new SingletonGestorProdutos(context);
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
        if (!ProdutoJsonParser.isConnectionInternet(context))
            Toast.makeText(context, "Não tem ligação à internet", Toast.LENGTH_SHORT).show();
        else {
            JSONObject jsonParams = new JSONObject();
            try {
                jsonParams.put("username", username);
                jsonParams.put("password", password);
            } catch (JSONException e) {
                e.printStackTrace();
            }
            JsonObjectRequest req = new JsonObjectRequest(Request.Method.POST, mUrlAPILogin(context), jsonParams, new Response.Listener<JSONObject>() {
                @Override
                public void onResponse(JSONObject response) {
                    utilizador = LoginJsonParser.parserJsonLogin(response);

                    // Save the user's ID, token, and username to SharedPreferences
                    saveUserId(context, utilizador.getId());
                    saveUserToken(context, utilizador.getAuth_key(), utilizador.getUsername());

                    // Add the user to the local database only if it doesn't already exist
                    if (utilizador.getId() != 0 || utilizador.getAuth_key() != null) {
                        getUserDataAPI(context);
                    }

                    if (loginListener != null) {
                        loginListener.onUpdateLogin(utilizador);
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, "Credenciais incorretas", Toast.LENGTH_SHORT).show();

                    if (utilizador != null) {
                        Log.e("LoginAPI", "Utilizador not null: " + utilizador.getUsername());
                        // Check if other conditions or actions need to be taken
                    } else {
                        Log.e("LoginAPI", "Utilizador is null");
                    }

                    // Check if loginListener is not null before using it
                    if (loginListener != null) {
                        loginListener.onUpdateLogin(utilizador);
                    }
                }
            });
            volleyQueue.add(req);
        }
    }

    public void getUserDataAPI(Context context) {
        if (!ProdutoJsonParser.isConnectionInternet(context)) {
            Toast.makeText(context, "Não tem ligação à internet", Toast.LENGTH_SHORT).show();
        } else {
            int utilizadorID = getUserId(context); // Fetch user ID from SharedPreferences
            JsonArrayRequest req = new JsonArrayRequest(Request.Method.GET, mUrlAPIUserData(context), null, new Response.Listener<JSONArray>() {
                @Override
                public void onResponse(JSONArray response) {
                    for (int i = 0; i < response.length(); i++) {
                        try {
                            JSONObject item = response.getJSONObject(i);
                            utilizadorData = LoginJsonParser.parserJsonGetUtilizadorData(item);

                            if (utilizadorListener != null) {
                                utilizadorListener.onGetUtilizadorData(utilizadorData);
                            }

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, error.getMessage(), Toast.LENGTH_SHORT).show();
                }
            });
            volleyQueue.add(req);
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
        return "http://" + getApiIP(context) + "/dtlgleiwebapp/detailingleiria/backend/web/api/users/" + getUserId(context) + "?access-token=" + getUserToken(context);
    }

    private String mUrlAPILogin(Context context) {

        return "http://" + getApiIP(context) + "/dtlgleiwebapp/detailingleiria/backend/web/api/auth/login";
    }
}
