package com.example.amsi;

import androidx.fragment.app.Fragment;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;

import com.example.amsi.adaptadores.ListaFaturasAdaptador;
import com.example.amsi.listeners.FaturasListener;
import com.example.amsi.modelo.Fatura;
import com.example.amsi.modelo.SingletonGestorProdutos;

import java.util.ArrayList;

public class ListaFaturasFragment extends Fragment implements FaturasListener {
    private ListView lvFaturas;
    private ListaFaturasAdaptador listaFaturasAdaptador;
    private ArrayList<Fatura> faturasList = new ArrayList<>();

    public ListaFaturasFragment() {
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View view = inflater.inflate(R.layout.lista_faturas_fragment, container, false);
        lvFaturas = view.findViewById(R.id.lvFaturas);

        listaFaturasAdaptador = new ListaFaturasAdaptador(getContext(), faturasList);
        lvFaturas.setAdapter(listaFaturasAdaptador);

        Log.d("ListaFaturasFragment", "Fragment criado, a buscar as faturas a API");

        SingletonGestorProdutos.getInstance(getContext()).setFaturasListener(this);
        SingletonGestorProdutos.getInstance(getContext()).getAllFaturasAPI(getContext());

        return view;
    }

    @Override
    public void onRefreshFaturas(ArrayList<Fatura> faturas) {
        Log.d("ListaFaturasFragment", "onRefreshFaturas chamado. Novo tamanho das faturas: " + faturas.size());

        if (faturas != null) {
            faturasList.clear();
            faturasList.addAll(faturas);
            listaFaturasAdaptador.notifyDataSetChanged();
        }
    }
}