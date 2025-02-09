package com.example.amsi.adaptadores;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.example.amsi.R;
import com.example.amsi.modelo.Fatura;
import com.example.amsi.modelo.SingletonGestorProdutos;

import java.util.ArrayList;

public class ListaFaturasAdaptador extends BaseAdapter {
    private Context context;
    private LayoutInflater inflater;
    private ArrayList<Fatura> faturas;

    public ListaFaturasAdaptador(Context context, ArrayList<Fatura> faturas) {
        this.context = context;
        this.faturas = faturas;
    }

    @Override
    public int getCount() {
        return faturas.size();
    }

    @Override
    public Object getItem(int i) {
        return faturas.get(i);
    }

    @Override
    public long getItemId(int i) {
        return faturas.get(i).getIdfatura();
    }

    @Override
    public View getView(int position, View view, ViewGroup viewGroup) {
        if (inflater == null) {
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }
        if (view == null) {
            view = inflater.inflate(R.layout.item_lista_fatura, null);
        }

        ViewHolderLista viewHolder = (ViewHolderLista) view.getTag();
        if (viewHolder == null) {
            viewHolder = new ViewHolderLista(view);
            view.setTag(viewHolder);
        }

        Fatura fatura = faturas.get(position);

        viewHolder.tvIdFatura.setText(String.valueOf(fatura.getIdfatura()));
        viewHolder.tvMetodoPagamento.setText(fatura.getMetodopagamento());
        viewHolder.tvMetodoEntrega.setText(fatura.getMetodoentrega());
        viewHolder.tvPrecoTotal.setText(String.format("%.2f€", fatura.getPrecototal()));
        viewHolder.tvDataVenda.setText(fatura.getDatavenda());

        viewHolder.btnDownloadPDF.setOnClickListener(v -> {
            Toast.makeText(context, "A fazer download da fatura...", Toast.LENGTH_SHORT).show();
            SingletonGestorProdutos.getInstance(context).downloadFaturaAPI(context, fatura.getIdfatura());
        });

        return view;
    }

    private static class ViewHolderLista {
        private TextView tvIdFatura, tvMetodoPagamento, tvMetodoEntrega, tvPrecoTotal, tvDataVenda;
        private Button btnDownloadPDF;

        public ViewHolderLista(View view) {
            tvIdFatura = view.findViewById(R.id.tvIdFatura);
            tvMetodoPagamento = view.findViewById(R.id.tvMetodoPagamento);
            tvMetodoEntrega = view.findViewById(R.id.tvMetodoEntrega);
            tvPrecoTotal = view.findViewById(R.id.tvPrecoTotal);
            tvDataVenda = view.findViewById(R.id.tvDataVenda);
            btnDownloadPDF = view.findViewById(R.id.btnDownloadPDF);
        }
    }
}

