package com.example.amsi;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;

import androidx.activity.EdgeToEdge;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.fragment.app.Fragment;

import com.example.amsi.adaptadores.ListaLinhasCarrinhoAdaptador;
import com.example.amsi.adaptadores.ListaLinhasFaturaAdaptador;
import com.example.amsi.listeners.CarrinhosListener;
import com.example.amsi.modelo.LinhasCarrinho;
import com.example.amsi.modelo.LinhasFatura;
import com.example.amsi.modelo.SingletonGestorProdutos;
import com.google.android.material.floatingactionbutton.FloatingActionButton;

import java.util.ArrayList;

public class ListaCarrinhoFragment extends Fragment implements CarrinhosListener {

    public static final String IDCARRINHO = "idCarrinho";
    private int idCarrinho;
    private FloatingActionButton fabLista;
    private ListView lvLinhasCarrinho;
    private ArrayList<LinhasCarrinho> linhasCarrinhoList;
    public static final int ADD=100;
    private ListaLinhasCarrinhoAdaptador adapter;

    public ListaCarrinhoFragment(){

    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.lista_carrinho_fragment, container, false);
        lvLinhasCarrinho = view.findViewById(R.id.lvLinhasCarrinho);

        linhasCarrinhoList = new ArrayList<>();
        adapter = new ListaLinhasCarrinhoAdaptador(getContext(), linhasCarrinhoList);
        lvLinhasCarrinho.setAdapter(adapter);

        if (getArguments() != null) {
            idCarrinho = getArguments().getInt(IDCARRINHO, -1);
        }

        SingletonGestorProdutos.getInstance(getContext()).setCarrinhosListener(this);
        SingletonGestorProdutos.getInstance(getContext()).getAllLinhasCarrinhoAPI(getContext(), idCarrinho);

        fabLista = view.findViewById(R.id.fabLista);
        fabLista.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent intent = new Intent(getContext(), FinalizarCompraActivity.class);
                startActivityForResult(intent, ADD);
            }
        });

        return view;
    }

    @Override
    public void onRefreshLinhasCarrinho(ArrayList<LinhasCarrinho> linhasCarrinho) {
        if (linhasCarrinho != null) {
            linhasCarrinhoList.clear();
            linhasCarrinhoList.addAll(linhasCarrinho);
            adapter.notifyDataSetChanged();
        }
    }

    @Override
    public void onLinhaCarrinhoRemovida(int idLinhaCarrinho) {

    }
}