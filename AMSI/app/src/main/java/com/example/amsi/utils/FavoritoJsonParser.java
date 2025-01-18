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

        // Check if the response is null or empty
        if (response == null || response.isEmpty()) {
            Log.e("JSON Error", "Received empty or null response.");
            return favoritos; // Return empty list if the response is invalid
        }

        try {
            // Log the raw response for debugging
            Log.e("Raw JSON Response", response);

            // Parse the response as an outer array
            JSONArray outerArray = new JSONArray(response);

            // Since the outer array contains inner arrays, iterate through them
            for (int i = 0; i < outerArray.length(); i++) {
                // Get the first inner array containing the data we want
                JSONArray favoritosArray = outerArray.getJSONArray(i);

                // Iterate through the items inside the inner array
                for (int j = 0; j < favoritosArray.length(); j++) {
                    // Get the JSON object of each "favorito"
                    JSONObject favoritoJSON = favoritosArray.getJSONObject(j);

                    // Map JSON fields to Favorito object properties
                    int idfavorito = favoritoJSON.optInt("idfavorito", -1);
                    int idproduto = favoritoJSON.optInt("idproduto", -1);
                    int idprofile = favoritoJSON.optInt("idprofile", -1);
                    String nomeproduto = favoritoJSON.optString("nomeproduto", "Unknown");
                    double preco = favoritoJSON.optDouble("preco", 0.0);
                    String imagem = favoritoJSON.optString("imagem", "");

                    // Create a new Favorito object
                    Favorito favorito = new Favorito(idfavorito, idproduto, idprofile, nomeproduto, (float) preco, imagem);
                    favoritos.add(favorito);
                }
            }

        } catch (JSONException e) {
            // Log the error in more detail for debugging
            Log.e("JSON Parsing Error", "Error parsing JSON: " + e.getMessage());
            e.printStackTrace();
        }

        return favoritos;
    }
}



