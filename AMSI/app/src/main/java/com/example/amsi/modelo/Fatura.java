package com.example.amsi.modelo;

public class Fatura {
    private int idprofile, idfatura;
    private double precototal;
    private String datavenda, metodopagamento, metodoentrega;

    public Fatura() {
    }


    public Fatura(int idprofile, int idfatura, String metodopagamento, String metodoentrega, double precototal, String datavenda) {
        this.idprofile = idprofile;
        this.idfatura = idfatura;
        this.metodopagamento = metodopagamento;
        this.metodoentrega = metodoentrega;
        this.precototal = precototal;
        this.datavenda = datavenda;
    }

    // Getters e Setters
    public int getIdprofile() { return idprofile; }

    public void setIdprofile(int idprofile) { this.idprofile = idprofile; }

    public int getIdfatura() { return idfatura; }

    public void setIdfatura(int idfatura) { this.idfatura = idfatura; }

    public String getMetodopagamento() { return metodopagamento; }

    public void setMetodopagamento(String metodopagamento) { this.metodopagamento = metodopagamento; }

    public String getMetodoentrega() { return metodoentrega; }

    public void setMetodoentrega(String metodoentrega) { this.metodoentrega = metodoentrega; }

    public double getPrecototal() { return precototal; }

    public void setPrecototal(double precototal) { this.precototal = precototal; }

    public String getDatavenda() { return datavenda; }

    public void setDatavenda(String datavenda) { this.datavenda = datavenda; }
}
