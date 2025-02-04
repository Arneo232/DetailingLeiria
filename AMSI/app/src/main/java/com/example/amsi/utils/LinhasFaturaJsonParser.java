package com.example.amsi.utils;

import org.json.JSONArray;
import org.json.JSONObject;
import com.example.amsi.modelo.LinhasFatura;

import java.util.ArrayList;

public class LinhasFaturaJsonParser {

    public static ArrayList<LinhasFatura> parserJsonLinhasFatura(String response) {
        ArrayList<LinhasFatura> linhasFaturaList = new ArrayList<>();

        try {
            JSONArray outerArray = new JSONArray(response);

            JSONObject faturaObject = outerArray.getJSONArray(0).getJSONObject(0);

            JSONArray linhasVendaArray = faturaObject.getJSONArray("linhasVenda");

            for (int i = 0; i < linhasVendaArray.length(); i++) {
                JSONObject linha = linhasVendaArray.getJSONObject(i);

                LinhasFatura linhasFatura = new LinhasFatura();
                linhasFatura.setIdLinhasvenda(linha.getInt("idLinhaVenda"));
                linhasFatura.setQuantidade(linha.getInt("quantidade"));
                linhasFatura.setPrecounitario(linha.getDouble("precounitario"));
                linhasFatura.setSubtotal(linha.getDouble("subtotal"));
                linhasFatura.setNomeproduto(linha.getString("nomeProduto"));

                linhasFaturaList.add(linhasFatura);
            }

        } catch (Exception e) {
            e.printStackTrace();
        }

        return linhasFaturaList;
    }
}
