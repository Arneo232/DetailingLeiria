package com.example.amsi.listeners;

import com.example.amsi.modelo.Produto;

import java.util.ArrayList;

public interface ProdutosListener {

    void onRefreshListaProdutos(ArrayList<Produto> listaProdutos);
}
