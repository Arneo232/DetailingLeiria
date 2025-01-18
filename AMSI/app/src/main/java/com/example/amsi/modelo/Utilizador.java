package com.example.amsi.modelo;

public class Utilizador {
    public int id;
    public String username;
    public String email;
    public String password;
    public String ntelefone;
    public String morada;
    public String token;

    public Utilizador(){

    }

    public Utilizador(String username, String email, String password, String ntelefone, String morada) {
        this.username = username;
        this.email = email;
        this.password = password;
        this.ntelefone = ntelefone;
        this.morada = morada;
    }

    public void setId(int id) { this.id = id; }

    public void setUsername(String username) { this.username = username; }

    public void setEmail(String email) {
        this.email = email;
    }

    public void setPassword(String password) { this.password = password; }

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

    public String getPassword() { return password; }

    public String getNtelefone() {
        return ntelefone;
    }

    public String getMorada() {
        return morada;
    }

    public String getToken() { return token; }

}
