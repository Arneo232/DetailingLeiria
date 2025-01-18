package com.example.amsi.utils;

import org.json.JSONException;
import org.json.JSONObject;

import com.example.amsi.modelo.Utilizador;

import java.util.HashMap;
import java.util.Map;

public class LoginJsonParser {
    public static Utilizador parserJsonLogin(String response) {
        Utilizador utilizadorData = new Utilizador();
        try{
            JSONObject loginJson = new JSONObject(response);
            utilizadorData.setToken(loginJson.getString("token"));
            utilizadorData.setUsername(loginJson.getString("username"));
            utilizadorData.setEmail(loginJson.getString("email"));
            utilizadorData.setNtelefone(loginJson.getString("ntelefone"));
            utilizadorData.setMorada(loginJson.getString("morada"));
            utilizadorData.setId(loginJson.getInt("id"));
        }catch(JSONException e){
            throw new RuntimeException(e);
        }
        return utilizadorData;
    }
}
