package com.example.amsi.modelo;

public class Favorito {
    private int idfavorito, idproduto, idprofile;
    private double preco;
    private String nomeproduto, imagem;

    public void Favorito(){

    }

    public Favorito(int idfavorito, int idproduto, int idprofile, String nomeproduto, double preco, String imagem){
        this.idfavorito = idfavorito;
        this.idproduto = idproduto;
        this.idprofile = idprofile;
        this.nomeproduto = nomeproduto;
        this.preco = preco;
        this.imagem = imagem;
    }

    public int getIdfavorito() {
        return idfavorito;
    }

    public void setIdfavorito(int idfavorito) { this.idfavorito = idfavorito; }

    public int getIdproduto() { return idproduto; }

    public void setIdproduto(int idproduto) { this.idproduto = idproduto; }

    public int getIdprofile() { return idprofile; }

    public void setIdprofile(int idprofile) { this.idprofile = idprofile; }

    public double getPreco() { return preco; }

    public void setPreco(float preco) { this.preco = preco; }

    public String getNome() { return nomeproduto; }

    public void setNome(String nomeproduto) { this.nomeproduto = nomeproduto; }

    public String getImagem() { return imagem; }

    public void setImagem(String imagem) { this.imagem = imagem; }
}


