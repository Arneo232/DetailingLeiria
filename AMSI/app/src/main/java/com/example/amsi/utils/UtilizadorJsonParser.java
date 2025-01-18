package com.example.amsi.utils;

import com.example.amsi.modelo.Utilizador;

import org.json.JSONException;
import org.json.JSONObject;

public class UtilizadorJsonParser {
    public static Utilizador parserJsonUtilizador(String response) {
        Utilizador utilizador = new Utilizador();
        try {
            JSONObject utilizadorJSON = new JSONObject(response);

            utilizador.setId(utilizadorJSON.getInt("id"));
            utilizador.setIdprofile(utilizadorJSON.getInt("idProfile"));
            utilizador.setNtelefone(utilizadorJSON.getString("ntelefone"));
            utilizador.setUsername(utilizadorJSON.getString("username"));
            utilizador.setEmail(utilizadorJSON.getString("email"));
            utilizador.setToken(utilizadorJSON.getString("token"));
            utilizador.setMorada(utilizadorJSON.getString("morada"));

        } catch (JSONException e) {
            throw new RuntimeException(e);
        }

        return utilizador;
    }
}
