package com.example.amsi.modelo;

public class MetodoEntrega {
    private int idmetodoEntrega;
    private String designacao;

    public MetodoEntrega(int idmetodoEntrega, String designacao) {
        this.idmetodoEntrega = idmetodoEntrega;
        this.designacao = designacao;
    }

    // Getters e setters
    public int getIdmetodoEntrega() {
        return idmetodoEntrega;
    }
    public String getDesignacao() {
        return designacao;
    }
    public void setDesignacao(String designacao) {
        this.designacao = designacao;
    }

    @Override
    public String toString() {
        return designacao;
    }
}
