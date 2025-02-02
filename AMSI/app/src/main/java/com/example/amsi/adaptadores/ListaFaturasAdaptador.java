package com.example.amsi.adaptadores;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.example.amsi.R;
import com.example.amsi.modelo.Fatura;
import com.example.amsi.modelo.Favorito;
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

        return view;
    }

    private class ViewHolderLista {
        private TextView tvIdFatura, tvMetodoPagamento, tvMetodoEntrega, tvPrecoTotal, tvDataVenda;

        public ViewHolderLista(View view) {
            tvIdFatura = view.findViewById(R.id.tvIdFatura);
            tvMetodoPagamento = view.findViewById(R.id.tvMetodoPagamento);
            tvMetodoEntrega = view.findViewById(R.id.tvMetodoEntrega);
            tvPrecoTotal = view.findViewById(R.id.tvPrecoTotal);
            tvDataVenda = view.findViewById(R.id.tvDataVenda);
        }
    }
}
