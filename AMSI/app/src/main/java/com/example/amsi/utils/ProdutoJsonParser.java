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

    public static ArrayList<Produto> parserJsonProdutos(JSONArray response, Context context) {
        ArrayList<Produto> produtos = new ArrayList<>();
        SharedPreferences sharedIP = context.getSharedPreferences("IP", MODE_PRIVATE);
        String ip = sharedIP.getString("ip", "");
        try {
            for (int i = 0; i < response.length(); i++) {
                JSONObject produtoJSON = (JSONObject) response.get(i);

                int idProduto = produtoJSON.getInt("idProduto");  // Verifica o nome exato da chave
                String nome = produtoJSON.getString("nome");
                String descricao = produtoJSON.getString("descricao");
                double preco = produtoJSON.getDouble("preco");
                int stock = produtoJSON.getInt("stock");  // Verifica o nome exato da chave
                int idCategoria = produtoJSON.getInt("idCategoria");  // Verifica o nome exato da chave
                int fornecedoresId = produtoJSON.getInt("fornecedores_idfornecedores");  // Verifica o nome exato da chave
                int idDesconto = produtoJSON.getInt("idDesconto");  // Verifica o nome exato da chave
                //String imagem = "http://localhost/DetailingLeiria/dtlgleiwebapp/frontend/web/uploads/" + produtoJSON.getString("file_id");

                Produto produto = new Produto(idProduto, nome, descricao, preco, stock, idCategoria, fornecedoresId, idDesconto);
                produtos.add(produto);
            }
        } catch (JSONException e) {
            throw new RuntimeException(e);
        }
        return produtos;
    }

    public static Produto parserJsonProduto(String response) {
        Produto produto = null;
        try {
            JSONObject produtoJSON = new JSONObject(response);

            int idProduto = produtoJSON.getInt("idProduto");  // Verifica o nome exato da chave
            String nome = produtoJSON.getString("nome");
            String descricao = produtoJSON.getString("descricao");
            double preco = produtoJSON.getDouble("preco");
            int stock = produtoJSON.getInt("stock");  // Verifica o nome exato da chave
            int idCategoria = produtoJSON.getInt("idCategoria");  // Verifica o nome exato da chave
            int fornecedoresId = produtoJSON.getInt("fornecedoresId");  // Verifica o nome exato da chave
            int idDesconto = produtoJSON.getInt("idDesconto");  // Verifica o nome exato da chave
            //String imagem = produtoJSON.getString("file_id");

            produto = new Produto(idProduto, nome, descricao, preco, stock, idCategoria, fornecedoresId, idDesconto);
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
