package com.example.amsi.utils;

import com.example.amsi.modelo.Avaliacao;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class AvaliacaoJsonParser {

    public static ArrayList<Avaliacao> parseJsonAvaliacoes(JSONArray response) {
        ArrayList<Avaliacao> listaAvaliacoes = new ArrayList<>();

        try {
            if (response.length() > 0) {
                JSONArray avaliacoesArray = response.getJSONArray(0);

                for (int i = 0; i < avaliacoesArray.length(); i++) {
                    JSONObject jsonObject = avaliacoesArray.getJSONObject(i);

                    int idAvaliacao = jsonObject.getInt("idavaliacao");
                    double rating = jsonObject.getDouble("rating");
                    String comentario = jsonObject.getString("comentario");
                    String utilizador = jsonObject.getString("utilizador");
                    int idProdutoFK = jsonObject.getInt("idProdutoFK");
                    int idProfileFK = jsonObject.getInt("idProfileFK");

                    Avaliacao avaliacao = new Avaliacao(idAvaliacao, idProdutoFK, idProfileFK, rating, utilizador, comentario);
                    listaAvaliacoes.add(avaliacao);
                }
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return listaAvaliacoes;
    }
}