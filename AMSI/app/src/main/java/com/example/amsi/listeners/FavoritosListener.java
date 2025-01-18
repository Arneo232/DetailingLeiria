package com.example.amsi.listeners;

import com.example.amsi.modelo.Favorito;

import java.util.ArrayList;

public interface FavoritosListener {
    void onRefreshFavoritos(ArrayList<Favorito> favorito);
}
