package com.example.amsi.modelo;

public class MetodoPagamento {
    private int idMetodoPagamento;
    private String designacao;

    public MetodoPagamento(int idMetodoPagamento, String designacao) {
        this.idMetodoPagamento = idMetodoPagamento;
        this.designacao = designacao;
    }

    // Getters e setters
    public int getidMetodoPagamento() {
        return idMetodoPagamento;
    }
    public String getDesignacao() {
        return designacao;
    }
    public void setDesignacao(String designacao) {
        this.designacao = designacao;
    }

}
