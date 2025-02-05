package com.example.amsi.utils;

import org.json.JSONArray;
import org.json.JSONObject;
import com.example.amsi.modelo.LinhasCarrinho;

import java.util.ArrayList;

public class LinhasCarrinhoJsonParser {

    public static ArrayList<LinhasCarrinho> parserJsonLinhasCarrinho(String response) {
        ArrayList<LinhasCarrinho> linhasCarrinhoList = new ArrayList<>();

        try {
            JSONArray outerArray = new JSONArray(response);

            JSONObject carrinhoObject = outerArray.getJSONArray(0).getJSONObject(0);

            JSONArray linhasCarrinhoArray = carrinhoObject.getJSONArray("linhasCarrinho");

            for (int i = 0; i < linhasCarrinhoArray.length(); i++) {
                JSONObject linha = linhasCarrinhoArray.getJSONObject(i);
                LinhasCarrinho linhasCarrinho = new LinhasCarrinho();
                linhasCarrinho.setIdLinhaCarrinho(linha.getInt("idLinhaCarrinho"));
                linhasCarrinho.setIdProduto(linha.getInt("idProduto"));
                linhasCarrinho.setQuantidade(linha.getInt("quantidade"));
                linhasCarrinho.setPrecounitario(linha.getDouble("precounitario"));
                linhasCarrinho.setSubtotal(linha.getDouble("subtotal"));
                linhasCarrinho.setNomeProduto(linha.getString("nomeProduto"));
                linhasCarrinho.setImagem(linha.getString("imagem"));
                linhasCarrinhoList.add(linhasCarrinho);
            }

        } catch (Exception e) {
            e.printStackTrace();
        }

        return linhasCarrinhoList;
    }
}
