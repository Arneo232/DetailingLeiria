package com.example.amsi.modelo;

public class Utilizador {
    private int id;
    private String username;
    private String email;
    private String ntelefone;
    private String morada;
    private String token;

    public Utilizador(){

    }

    public Utilizador(int id, String username, String email, String ntelefone, String morada, String token) {
        this.id = id;
        this.username = username;
        this.email = email;
        this.ntelefone = ntelefone;
        this.morada = morada;
        this.token = token;
    }

    public void setId(int id) {
        this.id = id;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public void setNtelefone(String ntelefone) {
        this.ntelefone = ntelefone;
    }

    public void setMorada(String morada) {
        this.morada = morada;
    }

    public void setToken(String token) { this.token = token; }

    public int getId() {
        return id;
    }

    public String getUsername() {
        return username;
    }

    public String getEmail() {
        return email;
    }

    public String getNtelefone() {
        return ntelefone;
    }

    public String getMorada() {
        return morada;
    }

    public String getToken() { return token; }

}
