package com.example.amsi.utils;

import org.json.JSONArray;
import org.json.JSONObject;
import com.example.amsi.modelo.LinhasFatura;
import java.util.ArrayList;

public class LinhasFaturaJsonParser {

    public static ArrayList<LinhasFatura> parserJsonLinhasFatura(String response, int idFatura) {
        ArrayList<LinhasFatura> linhasFaturaList = new ArrayList<>();

        try {
            JSONArray outerArray = new JSONArray(response);

            for (int i = 0; i < outerArray.length(); i++) {
                JSONArray innerArray = outerArray.getJSONArray(i);

                for (int j = 0; j < innerArray.length(); j++) {
                    JSONObject faturaObject = innerArray.getJSONObject(j);

                    if (faturaObject.getInt("idvendas") == idFatura) {
                        JSONArray linhasVendaArray = faturaObject.getJSONArray("linhasVenda");

                        for (int k = 0; k < linhasVendaArray.length(); k++) {
                            JSONObject linha = linhasVendaArray.getJSONObject(k);

                            LinhasFatura linhasFatura = new LinhasFatura();
                            linhasFatura.setIdLinhasvenda(linha.getInt("idLinhaVenda"));
                            linhasFatura.setQuantidade(linha.getInt("quantidade"));
                            linhasFatura.setPrecounitario(linha.getDouble("precounitario"));
                            linhasFatura.setSubtotal(linha.getDouble("subtotal"));
                            linhasFatura.setNomeproduto(linha.getString("nomeProduto"));

                            linhasFaturaList.add(linhasFatura);
                        }
                        return linhasFaturaList;
                    }
                }
            }

        } catch (Exception e) {
            e.printStackTrace();
        }

        return linhasFaturaList;
    }
}
