package com.example.amsi.listeners;

import com.example.amsi.modelo.Avaliacao;

import java.util.ArrayList;

public interface AvaliacoesListener {
    void onRefreshAvaliacoes(ArrayList<Avaliacao> avaliacoes);
}
