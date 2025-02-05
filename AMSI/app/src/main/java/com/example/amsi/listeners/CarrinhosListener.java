package com.example.amsi.listeners;

import com.example.amsi.modelo.Favorito;
import com.example.amsi.modelo.LinhasCarrinho;

import java.util.ArrayList;

public interface CarrinhosListener {
    void onRefreshLinhasCarrinho(ArrayList<LinhasCarrinho> linhasCarrinho);
    void onLinhaCarrinhoRemovida(int idLinhaCarrinho);
}
