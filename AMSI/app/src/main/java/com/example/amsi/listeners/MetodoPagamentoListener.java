package com.example.amsi.listeners;

import com.example.amsi.modelo.MetodoPagamento;
import java.util.List;

public interface MetodoPagamentoListener {
    void onMetodosPagamentoObtidos(List<MetodoPagamento> metodosPagamento);
}
