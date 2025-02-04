package com.example.amsi.listeners;

import com.example.amsi.modelo.Fatura;
import com.example.amsi.modelo.LinhasFatura;

import java.util.ArrayList;

public interface FaturaListener {

    void onRefreshDetalhes(ArrayList<LinhasFatura> linhaFatura);
}
