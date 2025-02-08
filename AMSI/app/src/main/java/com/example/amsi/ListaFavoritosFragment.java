package com.example.amsi;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ListView;
import android.widget.SearchView;

import androidx.fragment.app.Fragment;

import com.example.amsi.adaptadores.ListaFavoritosAdaptador;
import com.example.amsi.listeners.FavoritosListener;
import com.example.amsi.modelo.Favorito;
import com.example.amsi.modelo.FavoritoBDHelper;
import com.example.amsi.modelo.SingletonGestorProdutos;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import java.util.ArrayList;

public class ListaFavoritosFragment extends Fragment implements FavoritosListener {

    private ListView lvFavoritos;

    public ListaFavoritosFragment() {
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.lista_favoritos_fragment, container, false);
        lvFavoritos = view.findViewById(R.id.lvFavoritos);

        Log.d("ListaFavoritosFragment", "Fragment criado, a buscar os favoritos a API");

        SingletonGestorProdutos.getInstance(getContext()).setFavoritosListener(this);
        SingletonGestorProdutos.getInstance(getContext()).getAllFavoritosAPI(getContext());

        carregarFavoritosBD();

        return view;
    }

    private void carregarFavoritosBD() {
        ArrayList<Favorito> favoritos = SingletonGestorProdutos.getInstance(getContext()).getFavoritosBD();
        Log.d("ListaFavoritosFragment", "Depois de chamar o getFavoritoBD. Tamanho dos Favoritos: " + favoritos.size());

        if (favoritos != null && !favoritos.isEmpty()) {
            lvFavoritos.setAdapter(new ListaFavoritosAdaptador(getContext(), favoritos));
        }
    }

    @Override
    public void onRefreshFavoritos(ArrayList<Favorito> favorito) {
        Log.d("ListaFavoritosFragment", "onRefreshFavoritos chamado. Novo tamanho dos favoritos: " + favorito.size());

        if (favorito != null && !favorito.isEmpty()) {
            lvFavoritos.setAdapter(new ListaFavoritosAdaptador(getContext(), favorito));
        }
    }
}
