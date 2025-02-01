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

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
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
    private ArrayList<Favorito> favorito;

    private FloatingActionButton fablista;
    private SearchView searchView;

    public ListaFavoritosFragment() {
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.lista_favoritos_fragment, container, false);
        lvFavoritos = view.findViewById(R.id.lvFavoritos);

        Log.d("ListaFavoritosFragment", "Before calling getFavoritoBD");

        ArrayList<Favorito> favoritos = SingletonGestorProdutos.getInstance(getContext()).getFavoritoBD(getContext());

        Log.d("ListaFavoritosFragment", "After calling getFavoritoBD. Favoritos size: " + favoritos.size());

        if (favoritos != null && !favoritos.isEmpty()) {
            lvFavoritos.setAdapter(new ListaFavoritosAdaptador(getContext(), favoritos));
        }

        return view;
    }

    @Override
    public void onRefreshFavoritos(ArrayList<Favorito> favorito) {
        if (favorito != null) {
            lvFavoritos.setAdapter(new ListaFavoritosAdaptador(getContext(), favorito));
        }
    }
}
