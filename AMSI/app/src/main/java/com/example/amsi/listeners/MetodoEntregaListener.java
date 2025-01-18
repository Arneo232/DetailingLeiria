package com.example.amsi.listeners;

import com.example.amsi.modelo.MetodoEntrega;
import java.util.List;

public interface MetodoEntregaListener {
    void onMetodosEntregaObtidos(List<MetodoEntrega> metodosEntrega);
}
