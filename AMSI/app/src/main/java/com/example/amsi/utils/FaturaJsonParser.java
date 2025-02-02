package com.example.amsi.utils;

import android.util.Log;

import com.example.amsi.modelo.Fatura;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class FaturaJsonParser {
    public static ArrayList<Fatura> parserJsonFaturas(String response) {
        ArrayList<Fatura> faturas = new ArrayList<>();

        if (response == null || response.isEmpty()) {
            Log.e("JSON Error", "Received empty or null response.");
            return faturas;
        }

        try {
            Log.e("Raw JSON Response", response);

            JSONArray outerArray = new JSONArray(response);

            for (int i = 0; i < outerArray.length(); i++) {
                JSONArray faturasArray = outerArray.getJSONArray(i);

                for (int j = 0; j < faturasArray.length(); j++) {
                    JSONObject faturaJSON = faturasArray.getJSONObject(j);

                    int idprofile = faturaJSON.optInt("idProfile", -1);
                    int idfatura = faturaJSON.optInt("idvendas", -1);
                    String metodoentrega = faturaJSON.optString("metodoentrega", "Unknown");
                    String metodopagamento = faturaJSON.optString("metodopagamento", "Unknown");
                    String datavenda = faturaJSON.optString("datavenda", "Unknown");
                    double precototal = faturaJSON.optDouble("total", 0.0);

                    Fatura fatura = new Fatura(idprofile, idfatura, metodopagamento, metodoentrega, precototal, datavenda);
                    faturas.add(fatura);
                }
            }

        } catch (JSONException e) {
            Log.e("JSON Parsing Error", "Error parsing JSON: " + e.getMessage());
            e.printStackTrace();
        }

        return faturas;
    }
}
