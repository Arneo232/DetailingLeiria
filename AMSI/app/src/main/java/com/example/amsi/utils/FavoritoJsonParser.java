package com.example.amsi.utils;

import com.example.amsi.modelo.Favorito;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class FavoritoJsonParser {
    public static ArrayList<Favorito> parserJsonFavoritos(JSONArray response) {
        ArrayList<Favorito> favoritos = new ArrayList<>();
        //SharedPreferences sharedIP  = context.getSharedPreferences("IP", Context.MODE_PRIVATE);
        //String ip = sharedIP.getString("ip", "");

        try {
            for (int i = 0; i < response.length(); i++) {
                JSONObject favoritoJSON = (JSONObject) response.get(i);

                int idfavorito = favoritoJSON.getInt("id");
                int idproduto = favoritoJSON.getInt("idProduto");
                int idutilizador = favoritoJSON.getInt("idUtilizador");
                String nome = favoritoJSON.getString("nome");
                double preco = favoritoJSON.getDouble("preco");
                String imagem = favoritoJSON.getString("imagem");

                Favorito favorito = new Favorito(idfavorito, idproduto, idutilizador, nome, preco, imagem);
                favoritos.add(favorito);
            }
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }

        return favoritos;
    }
}
