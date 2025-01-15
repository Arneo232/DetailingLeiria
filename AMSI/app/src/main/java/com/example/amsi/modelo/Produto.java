package com.example.amsi.modelo;

public class Produto {
    private int idProduto;
    private String nome;
    private String descricao;
    private double preco;
    private int stock;
    private int idCategoria;
    private int fornecedoresId;
    private int idDesconto;

    public Produto(int idProduto, String nome, String descricao, double preco, int stock, int idCategoria, int fornecedoresId, int idDesconto) {
        this.idProduto = idProduto;
        this.nome = nome;
        this.descricao = descricao;
        this.preco = preco;
        this.stock = stock;
        this.idCategoria = idCategoria;
        this.fornecedoresId = fornecedoresId;
        this.idDesconto = idDesconto;
    }

    // Getters e setters
    public int getIdProduto() {
        return idProduto;
    }

    public String getNome() {
        return nome;
    }

    public double getPreco() {
        return preco;
    }

    public String getDescricao() {
        return descricao;
    }
}
