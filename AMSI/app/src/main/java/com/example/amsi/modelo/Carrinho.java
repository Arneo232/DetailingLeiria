package com.example.amsi.modelo;

public class Carrinho {
    private int idCarrinho, idProfile;
    private float total;
    private String metodoEntrega, metodoPagamento;

    public Carrinho(int idCarrinho, int idProfile, float total, String metodoEntrega, String metodoPagamento) {
        this.idCarrinho = idCarrinho;
        this.idProfile = idProfile;
        this.total = total;
        this.metodoEntrega = metodoEntrega;
        this.metodoPagamento = metodoPagamento;
    }

    public void setIdCarrinho(int idCarrinho){ this.idCarrinho = idCarrinho; }

    public void setIdProfile(int idProfile){ this.idProfile = idProfile; }

    public void setTotal(float total){ this.total = total; }

    public void setMetodoEntrega(String metodoEntrega){ this.metodoEntrega = metodoEntrega; }

    public void setMetodoPagamento(String metodoPagamento){ this.metodoPagamento = metodoPagamento; }

    public int getIdCarrinho(){ return idCarrinho; }

    public int getIdProfile(){ return idProfile; }

    public float getTotal(){ return total; }

    public String getMetodoEntrega(){ return metodoEntrega; }

    public String getMetodoPagamento(){ return metodoPagamento; }
}
