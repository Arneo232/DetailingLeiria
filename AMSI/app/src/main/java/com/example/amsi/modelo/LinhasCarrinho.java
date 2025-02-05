package com.example.amsi.modelo;

import com.example.amsi.utils.LinhasCarrinhoJsonParser;

public class LinhasCarrinho {
    private int idLinhaCarrinho, idProduto, quantidade;
    private String nomeProduto, imagem;
    private double precounitario, subtotal;

    public LinhasCarrinho(){

    }

    public LinhasCarrinho(int idLinhaCarrinho, int idProduto, int quantidade, String nomeProduto, String imagem, double precounitario, double subtotal){
        this.idLinhaCarrinho = idLinhaCarrinho;
        this.idProduto = idProduto;
        this.quantidade = quantidade;
        this.nomeProduto = nomeProduto;
        this.imagem = imagem;
        this.precounitario = precounitario;
        this.subtotal = subtotal;
    }

    //Getters e Setters
    public int getIdLinhaCarrinho() { return idLinhaCarrinho; }

    public void setIdLinhaCarrinho(int idLinhaCarrinho) { this.idLinhaCarrinho = idLinhaCarrinho; }

    public int getIdProduto() { return idProduto; }

    public void setIdProduto(int idProduto) { this.idProduto = idProduto; }

    public int getQuantidade() { return quantidade; }

    public void setQuantidade(int quantidade) { this.quantidade = quantidade; }

    public String getNomeProduto() { return nomeProduto; }

    public void setNomeProduto(String nomeProduto) { this.nomeProduto = nomeProduto; }

    public String getImagem() { return imagem; }

    public void setImagem(String imagem) { this.imagem = imagem; }

    public double getPrecounitario() { return precounitario; }

    public void setPrecounitario(double precounitario) { this.precounitario = precounitario; }

    public double getSubtotal() { return subtotal; }

    public void setSubtotal(double subtotal) { this.subtotal = subtotal; }
}
