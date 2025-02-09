package com.example.amsi.adaptadores;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.TextView;

import com.example.amsi.R;
import com.example.amsi.modelo.LinhasFatura;

import java.util.ArrayList;

public class ListaLinhasFaturaAdaptador extends BaseAdapter {
    private Context context;
    private ArrayList<LinhasFatura> linhasFaturaList;

    public ListaLinhasFaturaAdaptador(Context context, ArrayList<LinhasFatura> linhasFaturaList) {
        this.context = context;
        this.linhasFaturaList = linhasFaturaList;
    }

    @Override
    public int getCount() {
        return linhasFaturaList.size();
    }

    @Override
    public Object getItem(int position) {
        return linhasFaturaList.get(position);
    }

    @Override
    public long getItemId(int position) {
        return linhasFaturaList.get(position).getIdLinhasvenda();
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        ViewHolder holder;

        if (convertView == null) {
            convertView = LayoutInflater.from(context).inflate(R.layout.item_linha_fatura, parent, false);
            holder = new ViewHolder();

            holder.tvNomeProduto = convertView.findViewById(R.id.tvNome);
            holder.tvPrecoUnitario = convertView.findViewById(R.id.tvPrecoUnitario);
            holder.tvQuantidade = convertView.findViewById(R.id.tvQuantidade);
            holder.tvSubtotal = convertView.findViewById(R.id.tvSubtotal);

            convertView.setTag(holder);
        } else {
            holder = (ViewHolder) convertView.getTag();
        }

        LinhasFatura linhaFatura = linhasFaturaList.get(position);

        holder.tvNomeProduto.setText(linhaFatura.getNomeproduto());
        holder.tvPrecoUnitario.setText(String.format("€%.2f", linhaFatura.getPrecounitario()));
        holder.tvQuantidade.setText(String.valueOf(linhaFatura.getQuantidade()));
        holder.tvSubtotal.setText(String.format("€%.2f", linhaFatura.getSubtotal()));

        return convertView;
    }

    static class ViewHolder {
        TextView tvNomeProduto;
        TextView tvPrecoUnitario;
        TextView tvQuantidade;
        TextView tvSubtotal;
    }
}
