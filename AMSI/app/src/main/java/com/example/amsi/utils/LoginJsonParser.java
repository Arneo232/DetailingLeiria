package com.example.amsi.utils;

import org.json.JSONException;
import org.json.JSONObject;

import com.example.amsi.modelo.Utilizador;

import java.util.HashMap;
import java.util.Map;

public class LoginJsonParser {
    public static Map<String, String> parserJsonLogin(String response) {
        Map<String, String> utilizadorData = new HashMap<>();
        try{
            JSONObject loginJson = new JSONObject(response);
            utilizadorData.put("auth_key", loginJson.getString("auth_key"));
            utilizadorData.put("username", loginJson.getString("username"));
            utilizadorData.put("email", loginJson.getString("email"));
            utilizadorData.put("profile_id", String.valueOf(loginJson.getInt("profile_id")));
        }catch(JSONException e){
            throw new RuntimeException(e);
        }
        return utilizadorData;
    }

}
