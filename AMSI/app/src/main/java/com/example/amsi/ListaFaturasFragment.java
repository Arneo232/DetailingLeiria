    package com.example.amsi;

    import androidx.fragment.app.Fragment;

    import android.content.Intent;
    import android.os.Bundle;
    import android.util.Log;
    import android.view.LayoutInflater;
    import android.view.View;
    import android.view.ViewGroup;
    import android.widget.AdapterView;
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
            setHasOptionsMenu(true);
            lvFaturas = view.findViewById(R.id.lvFaturas);

            listaFaturasAdaptador = new ListaFaturasAdaptador(getContext(), faturasList);
            lvFaturas.setAdapter(listaFaturasAdaptador);

            SingletonGestorProdutos.getInstance(getContext()).setFaturasListener(this);
            SingletonGestorProdutos.getInstance(getContext()).getAllFaturasAPI(getContext());

            lvFaturas.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                @Override
                public void onItemClick(AdapterView<?> adapterView, View view, int position, long id) {
                    Fatura faturaSelecionada = (Fatura) adapterView.getItemAtPosition(position);

                    Intent intent = new Intent(getContext(), DetalheFaturaActivity.class);
                    intent.putExtra(DetalheFaturaActivity.IDFATURA, faturaSelecionada.getIdfatura());
                    startActivity(intent);
                }
            });

            return view;
        }

        @Override
        public void onRefreshFaturas(ArrayList<Fatura> faturas) {
            if (faturas != null) {
                faturasList.clear();
                faturasList.addAll(faturas);
                listaFaturasAdaptador.notifyDataSetChanged();
            }
        }
    }