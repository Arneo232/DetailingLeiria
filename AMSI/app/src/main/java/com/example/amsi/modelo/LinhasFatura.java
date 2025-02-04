package com.example.amsi.modelo;

public class LinhasFatura {
    private int idlinhavenda, quantidade;
    private double precounitario, subtotal;
    private String nomeproduto;

    public LinhasFatura(){

    }

    public LinhasFatura(int idlinhavenda, int quantidade, double precounitario, double subtotal, String nomeproduto){
        this.idlinhavenda = idlinhavenda;
        this.quantidade = quantidade;
        this.precounitario = precounitario;
        this.subtotal = subtotal;
        this.nomeproduto = nomeproduto;
    }

    // Getters e Setters
    public int getIdLinhasvenda() { return idlinhavenda; }
    public void setIdLinhasvenda(int idlinhavenda) { this.idlinhavenda = idlinhavenda; }
    public int getQuantidade() { return quantidade; }
    public void setQuantidade(int quantidade) { this.quantidade = quantidade; }
    public double getPrecounitario() { return precounitario; }
    public void setPrecounitario(double precounitario) { this.precounitario = precounitario; }
    public double getSubtotal() { return subtotal; }
    public void setSubtotal(double subtotal) { this.subtotal = subtotal; }
    public String getNomeproduto() { return nomeproduto; }
    public void setNomeproduto(String nomeproduto) { this.nomeproduto = nomeproduto; }
}
