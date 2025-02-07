package com.example.amsi.modelo;

public class Avaliacao {
    private int idavaliacao, idProdutoFK, idProfileFK;
    private double rating;
    private String utilizador, comentario;

    public Avaliacao() {
    }

    public Avaliacao(int idavaliacao, int idProdutoFK, int idProfileFK, double rating, String utilizador, String comentario) {
        this.idavaliacao = idavaliacao;
        this.idProdutoFK = idProdutoFK;
        this.idProfileFK = idProfileFK;
        this.rating = rating;
        this.utilizador = utilizador;
        this.comentario = comentario;
    }

    // Getters e Setters
    public int getIdavaliacao() { return idavaliacao; }

    public void setIdavaliacao(int idavaliacao) { this.idavaliacao = idavaliacao; }

    public int getIdProdutoFK() { return idProdutoFK; }

    public void setIdProdutoFK(int idProdutoFK) { this.idProdutoFK = idProdutoFK; }

    public int getIdProfileFK() { return idProdutoFK; }

    public void setIdProfileFK(int idProfileFK) { this.idProfileFK = idProfileFK; }

    public double getRating() { return rating; }

    public void setRating(double rating) { this.rating = rating; }

    public String getNomeutilizador() { return utilizador; }

    public void setNomeutilizador(String utilizador) { this.utilizador = utilizador; }

    public String getComentario() { return comentario; }

    public void setComentario(String comentario) { this.comentario = comentario; }
}
