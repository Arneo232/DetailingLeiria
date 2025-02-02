package com.example.amsi.listeners;

import com.example.amsi.modelo.Fatura;
import com.example.amsi.modelo.Favorito;

import java.util.ArrayList;

public interface FaturasListener {
    void onRefreshFaturas(ArrayList<Fatura> fatura);
}
