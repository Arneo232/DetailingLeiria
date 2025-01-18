package com.example.amsi.utils;

import android.util.Log;

import org.json.JSONException;
import org.json.JSONObject;

public class RegisterJsonParser {
    public static String parserJsonRegister(String response) {
        try {
            JSONObject message = new JSONObject(response);
            String msg = message.getString("message");
            Log.e("RegisterJsonParser", "Raw message: '" + msg + "'");
            Log.e("RegisterJsonParser", "Message length: " + msg.length());
            return msg != null ? msg.trim() : null;
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return null;
    }
}
