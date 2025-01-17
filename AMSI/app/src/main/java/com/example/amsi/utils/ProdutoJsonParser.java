package com.example.amsi.utils;

import static android.content.Context.MODE_PRIVATE;

import android.content.Context;
import android.content.SharedPreferences;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import com.example.amsi.modelo.Produto;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class ProdutoJsonParser {

    public static ArrayList<Produto> parserJsonProdutos(JSONArray produtosArray, Context context) {
        ArrayList<Produto> produtos = new ArrayList<>();
        try {
            for (int i = 0; i < produtosArray.length(); i++) {
                JSONObject produtoJSON = produtosArray.getJSONObject(i);

                // Extract product details
                int id = produtoJSON.getInt("id");
                String nome = produtoJSON.getString("nome");
                String descricao = produtoJSON.getString("descricao");
                double preco = produtoJSON.getDouble("preco");
                int stock = produtoJSON.getInt("stock");
                String categoria = produtoJSON.getString("categoria");
                String fornecedor = produtoJSON.getString("Fornecedor");
                String desconto = produtoJSON.getString("desconto");
                String imagem = produtoJSON.getString("imagem");

                // Create a Produto object and add it to the list
                Produto produto = new Produto(id, nome, descricao, preco, stock, categoria, fornecedor, desconto, imagem);
                produtos.add(produto);
            }
        } catch (JSONException e) {
            throw new RuntimeException("Erro ao analisar JSON: " + e.getMessage(), e);
        }
        return produtos;
    }

    public static Produto parserJsonProduto(String response) {
        Produto produto = null;
        try {
            JSONObject produtoJSON = new JSONObject(response);

            int idProduto = produtoJSON.getInt("id");  // Verifica o nome exato da chave
            String nome = produtoJSON.getString("nome");
            String descricao = produtoJSON.getString("descricao");
            double preco = produtoJSON.getDouble("preco");
            int stock = produtoJSON.getInt("stock");  // Verifica o nome exato da chave
            String idCategoria = produtoJSON.getString("categoria");  // Verifica o nome exato da chave
            String fornecedoresId = produtoJSON.getString("Fornecedor");  // Verifica o nome exato da chave
            String idDesconto = produtoJSON.getString("desconto");  // Verifica o nome exato da chave
            String imagem = produtoJSON.getString("imagem");

            produto = new Produto(idProduto, nome, descricao, preco, stock, idCategoria, fornecedoresId, idDesconto, imagem);
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return produto;
    }

    public static boolean isConnectionInternet(Context context) {
        ConnectivityManager cm = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo netInfo = cm.getActiveNetworkInfo();
        return (netInfo != null && netInfo.isConnected());
    }
}
