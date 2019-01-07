<div id="newClientModal" class="modal newClientModal modal-fixed-footer">
	<div class="modal-content">
		<div class="col s12">
			<h5>Nuevo cliente</h5>
		</div>
		<div class="row">
			<form id="newClientForm" class="col s12 no-padding" method="POST" action="clients">
				{{ csrf_field() }}
				<div class="row" style="margin-bottom: 10px;">
					<div class="col s12 grey-text text-darken-2"><b>Información general</b></div>
					<div class="input-field col s12 m6">
			          <input id="client_name" name="client_name" type="text" class="validate client_name" onblur="validateNewClientForm();" required>
			          <label for="client_name" data-error="Verifique este campo" data-success="Campo validado">Nombre*</label>
			        </div>
			        <div class="input-field col s12 m6">
			          <input id="client_phone" name="client_phone" type="tel" class="validate client_phone" onblur="validateNewClientForm();">
			          <label for="client_phone" data-error="Verifique este campo" data-success="Campo validado">Teléfono</label>
			        </div>
			        <div class="input-field col s12 m12">
			          <input id="client_email" name="client_email" type="email" class="client_email validate" onblur="validateNewClientForm();">
			          <label for="client_accounting_account">E-mail</label>
			        </div>
		        </div>
			</form>
		</div>
	</div>
	<div class="modal-footer">
		<a href="#!" class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></a>
		@if (Route::currentRouteName()=='clients.index')
			<button id="submit_button" onclick="submitNewClient();" class="modal-action btn waves-effect submit_button" disabled><b>Registrar</b></button>
		@else
			<button id="submit_button" onclick="ajaxNewClient();" class="modal-action btn waves-effect submit_button" disabled><b>Registrar</b></button>
		@endif
	</div>
</div>