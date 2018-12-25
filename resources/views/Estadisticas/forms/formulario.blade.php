<?php
/**
 * Created by PhpStorm.
 * User: andres
 * Date: 26/07/2017
 * Time: 9:31 AM
 */
?>


<div class="form-group">
    <section id="main-content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-8">
                                {!! Form::select('TIPO DE REPORTES', ['cant_puert_ingr' => 'Cantidad de ingresos por puerta'],null,['class'=>'form-control','id'=>'tipo']) !!}
                            </div>
                        </div><br><br>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('Fecha de Inicio', null, ['class' => 'control-label']) !!}
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                        <input class="datepicker input-group date form-control" id="fecha_incio" name="fecha_inicio">
                                </div>
                            </div>
                        </div><br><br>
                         <div class="row">
                             <div class="col-md-3">
                             {!! Form::label('Fecha de Fin', null, ['class' => 'control-label']) !!}
                             </div>
                             <div class="col-md-3">
                                 <div class="form-group">
                                     <input class="datepicker input-group date form-control" id="fecha_fin" name="fecha_fin">
                                 </div>
                             </div>
                         </div><br><br>

                    </div>
                    </div>
                </div>
            </div>
    </section>


</div>
