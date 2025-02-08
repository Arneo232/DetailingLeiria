package com.example.amsi.utils;

import android.util.Log;

import com.example.amsi.modelo.Favorito;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class FavoritoJsonParser {
    public static ArrayList<Favorito> parserJsonFavoritos(String response) {
        ArrayList<Favorito> favoritos = new ArrayList<>();

        if (response == null || response.isEmpty()) {
            Log.e("JSON Error", "Received empty or null response.");
            return favoritos;
        }

        try {
            Log.e("Raw JSON Response", response);
            JSONArray outerArray = new JSONArray(response);
            for (int i = 0; i < outerArray.length(); i++) {
                JSONArray favoritosArray = outerArray.getJSONArray(i);
                for (int j = 0; j < favoritosArray.length(); j++) {
                    JSONObject favoritoJSON = favoritosArray.getJSONObject(j);
                    int idfavorito = favoritoJSON.optInt("idfavorito", -1);
                    int idproduto = favoritoJSON.optInt("idproduto", -1);
                    int idprofile = favoritoJSON.optInt("idprofile", -1);
                    String nomeproduto = favoritoJSON.optString("nomeproduto", "Unknown");
                    double preco = favoritoJSON.optDouble("preco", 0.0);
                    String imagem = favoritoJSON.optString("imagem", "");

                    Favorito favorito = new Favorito(idfavorito, idproduto, idprofile, nomeproduto, (float) preco, imagem);
                    favoritos.add(favorito);
                }
            }

        } catch (JSONException e) {
            Log.e("JSON Parsing Error", "Error parsing JSON: " + e.getMessage());
            e.printStackTrace();
        }

        return favoritos;
    }
}



