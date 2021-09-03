<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
class Datatable 
{
    public function get_data($kolom,$filter = array(),$model,$attr = array())
    {
        $search     = $attr['search']['value'];
        $sWhere     = "";
        if (!empty($filter)) {
            foreach ($filter as $key => $value) {
                if ($key == 'custom') {
                    $sWhere .= " AND $value";
                }else{
                    $sWhere .= " AND ".$key."='$value'";
                }
            }
        }
        $aColumns   = [];
        foreach ($kolom as $key => $value) {
            if (!is_array($value)) {
                $aColumns[] = $value;
            }else{
                $aColumns[] = $key;
            }
        }
        if ( isset($search) && $search != "" ) {
            $sWhere = "AND (";
            for ( $i = 0 ; $i < count($aColumns) ; $i++ ) {
                    $sWhere .= " LOWER(".$aColumns[$i].") LIKE LOWER('%".($search)."%') OR ";
            }
            $sWhere = substr_replace( $sWhere, "", - 3 );
            $sWhere .= ')';
        }
        $CI =& get_instance();
        $CI->load->model($model,'modelku');

        $iTotalRecords  = $CI->modelku->get_total($sWhere,$aColumns);
        $length = intval($attr['length']);
        $length = $length < 0 ? $iTotalRecords : $length;
        $start  = intval($attr['start']);
        $draw       = intval($attr['draw']);
        // $iSortCol_0 = $attr['order'][0]['column'];
        $sOrder = "";
        if ( isset($start) && $length != '-1' ) {
            $sLimit = " limit ".intval($length)." offset ".intval( $start );
        }

        if ( isset($attr['order'][0]['column'])) {
                $sOrder = "ORDER BY ".($aColumns[$attr['order']['0']['column']-1]).' '.$attr['order']['0']['dir'];
                /*for ( $i = 0 ; $i < intval($attr['iSortingCols']) ; $i++ ) {
                    if ( $attr['bSortable_'.intval($attr['iSortCol_'.$i])] == "true" ) {
                        $sOrder .= "".$aColumns[ intval($this->input->post('iSortCol_'.$i)) ]." ".($attr['sSortDir_'.$i] === 'desc' ? 'asc' : 'desc') .", ";
                    }
                }

                $sOrder = substr_replace( $sOrder, "", - 2 );
                if ( $sOrder == "ORDER BY" ) {
                        $sOrder = "";
                }*/
        }
        $data = $CI->modelku->get_data($sLimit,$sWhere,$sOrder,$aColumns);
        $records        = array();
        $records["dataku"] = $data;
        $records["draw"] = $draw;
        $records["iTotalRecords"] = $iTotalRecords;
        $records["iTotalDisplayRecords"] = $iTotalRecords;
        return ($records);
    }
}