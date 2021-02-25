@extends('layouts.app')

@section('content')
<header>
    <!--Aqui vai o cabeçalho-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
        <div class="container ">
          <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="{{ route ('blocos.index') }}">Blocos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="{{ route ('bebedouros.index') }}">Bebedouros</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route ('solicitacoes.index') }}">Solicitações de troca</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="{{ route ('trocas.index') }}">Trocas de filtro</a>
              </li>
            </ul>
            <form class="d-flex" method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="btn btn-danger" type="submit">Logout</button>
            </form>
          </div>
        </div>
      </nav>
</header>

<section>
    <!--conteudo do dashboard-->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p2 mt-5">
                <div class="row">
                    <div class="col-6 d-flex justify-content-center">
                        <h5>Solicitaçẽs de trocas de filtro</h5>
                    </div>
                    <div class="col-6 d-flex justify-content-center">
                        <button type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal5">Solicitar uma troca</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-5">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-dark text-center">
                            <tr>
                            <th scope="col">Usuario</th>
                            <th scope="col">Bebedouro</th>
                            <th scope="col">Bloco</th>
                            <th scope="col">Motivo</th>
                            <th scope="col">Data</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                            <th scope="col"> </th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                          @foreach($solicitacaoTrocas as $solicitacao)
                            <tr>
                            <th scope="row">{{ $solicitacao->user->name }}</th>
                            <td>{{ $solicitacao->bebedouro->desc }}</td>
                            <td>{{ $solicitacao->bebedouro->bloco->desc }}</td>
                            <td><a class="d-inline-block text-truncate motivo-item" data-id="{{ $solicitacao->motivo }}" data-bs-toggle="modal" data-bs-target="#exampleModa2" style="max-width: 150px;">
                                {{ $solicitacao->motivo }}
                            </a></td>
                            <td>{{ $solicitacao->data->format('d/m/Y - h:m:s')}}</td>
                            @if ( $solicitacao->concluida )
                            <td> <span class="badge badge-pill badge-success bg-success">Concluído</span> </td>
                            @else
                            <td> <span class="badge badge-pill badge-warning bg-warning">Pendente</span> </td>
                            @endif

                            <td><i class="fas fa-edit edit-item" data-id="{{ $solicitacao->id }}" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
                              <i class="fas fa-trash mx-2 delete-item" data-id="{{ $solicitacao->id }}" data-bs-toggle="modal" data-bs-target="#exampleModa3"></i></td>
                            @if (!$solicitacao->concluida) <td> <button type="button" class="btn btn-outline-dark btn-sm atender-item" data-motivo="{{ $solicitacao->motivo }}" data-bebedouro="{{ $solicitacao->bebedouro->desc }}" data-id="{{ $solicitacao->id }}" data-bs-toggle="modal" data-bs-target="#exampleModa4">Atender Solicitação</button></td> @endif
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @php
          $itens = $solicitacaoTrocas;
          $totalPages = ceil($itens->total() / $itens->perPage());
          $start = 1;
          $totalOptions = 3;
          if ($itens->currentPage() != 1){
            if ($itens->hasMorePages() == 1){
              $start = $itens->currentPage() - 1;
            }else if ($itens->currentPage() >= $totalOptions){
              $start = $itens->currentPage() - 2;
            }
          }
        @endphp
        @if ($itens->hasPages())
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                      <li class="page-item @if ($itens->onFirstPage()) disabled @endif">
                        <a class="page-link" href="{{ $itens->previousPageUrl() }}" aria-label="Anterior">
                          <span aria-hidden="true">&laquo;</span>
                        </a>
                      </li>

                      @for ($i = $start; $i < $start + 3; $i++)
                          @if ($i == $itens->currentPage())
                          <li class="page-item active">
                          @elseif ($i <= $totalPages)
                          <li class="page-item">
                          @else
                          <li class="page-item disabled">
                          @endif
                          <a class="page-link" href="{{ route ('blocos.index') }}?page={{$i}}"> {{ $i }}</a>
                          </li>
                      @endfor
                      <li class="page-item @if ($itens->hasMorePages() == 0) disabled @endif">
                        <a class="page-link" href="{{ $itens->nextPageUrl() }}" aria-label="Próxima">
                          <span aria-hidden="true">&raquo;</span>
                        </a>
                      </li>
                    </ul>
                  </nav>
            </div>
        </div>
        @endif
    </div>
</section>

    <!-- Modal edit-->
    <script>
      $(document).on('click','.edit-item',function(){
          var dataID=$(this).attr('data-id');
          $('#solicitacao_id').val(dataID);
          $('#exampleModal').modal('show');
          $('#edit-form').attr('action', "{{ route('solicitacoes.update', '') }}/" + dataID);
      });
    </script>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar solicitação</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="edit-form" method="POST">
                  @csrf
                  @method('PUT')
              <div class="modal-body">
                  <span>Bebedouro</span>
                  <select class="form-select form-select-sm mb-2" name="bebedouro_id" aria-label=".form-select-sm example">
                    @foreach ($bebedouros as $bebedouro)
                        <option value="{{ $bebedouro->id }}">{{ $bebedouro->desc }} - {{ $bebedouro->bloco->desc }}</option>
                    @endforeach
                  </select>
                  <span>Motivo</span>
                  <!--<input class="form-control form-control-sm" type="text" aria-label=".form-control-sm example">-->
                  <textarea class="form-control" name="motivo" id="motivo" rows="3"></textarea>
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-danger">Confirmar</button>
              </div>
            </form>
        </div>
        </div>
    </div>

    <!--modal motivo-->
    <script>
      $(document).on('click','.motivo-item',function(){
          var dataID=$(this).attr('data-id');
          $('#motivo-modal').text(dataID);
      });
    </script>
    <div class="modal fade" id="exampleModa2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Motivo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- <p id="motivo-modal"></p> -->
                <textarea disabled class="form-control" id="motivo-modal" rows="3"></textarea>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
        </div>
    </div>

    <!--modal excluir-->
    <div class="modal fade" id="exampleModa3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Excluir solicitação</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Deseja mesmo excluir ? </h5>
            </div>
            <div class="modal-footer">
              <form action="{{ route('solicitacoes.destroy')}}" method="POST">
                    @csrf
                    @method('DELETE')
                <input type="hidden", name="solicitacao_troca_id" id="solicitacao_troca_id">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-danger">Confirmar</button>
              </form>
            </div>
        </div>
        </div>
    </div>
    <script>
      $(document).on('click','.delete-item',function(){
          var dataID=$(this).attr('data-id');
          $('#solicitacao_troca_id').val(dataID);
          $('#exampleModal3').modal('show');
      });
    </script>

    <!--modal botao atender solicitacao-->

    <div class="modal fade" id="exampleModa4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Atender solicitação</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('trocas.store') }}" method="POST" >
              @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <span>Bebedouro</span>
                        <input class="form-control" id="data-bebedouro" type="text" placeholder="Bebedouro" aria-label="Disabled input example" disabled>
                    </div>
                    <div class="col-6">
                        <span>Motivo</span>
                        <textarea class="form-control" id="data-motivo" type="text" aria-label="input example" disabled></textarea>
                    </div>
                </div>

                <span>Comentários</span>
                <input class="form-control form-control-sm" name="comentarios" type="text" aria-label=".form-control-sm example">
                <input type="hidden" name="solicitacao_troca_id" id="solicitacao_troca_id2">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">Realizar troca</button>
            </div>
          </form>
        </div>
        </div>
    </div>
    <script>
      $(document).on('click','.atender-item',function(){
          var dataID=$(this).attr('data-id');
          var bebedouro=$(this).attr('data-bebedouro');
          var motivo=$(this).attr('data-motivo');
          $('#solicitacao_troca_id2').val(dataID);
          $('#data-bebedouro').val(bebedouro);
          $('#data-motivo').val(motivo);
          $('#exampleModa4').modal('show');
      });
    </script>

    <!-- Modal botao solicitar troca-->
    <div class="modal fade" id="exampleModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Solicitar troca de filtro</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('solicitacoes.store') }}" method="POST" >
                @csrf
              <div class="modal-body">
                  <span>Bebedouro</span>
                  <select class="form-select form-select-sm mb-2" name="bebedouro_id" aria-label=".form-select-sm example">
                    @foreach ($bebedouros as $bebedouro)
                        <option value="{{ $bebedouro->id }}">{{ $bebedouro->desc }} - {{ $bebedouro->bloco->desc }}</option>
                    @endforeach
                  </select>
                  <span>Motivo</span>
                  <!--<input class="form-control form-control-sm" type="text" aria-label=".form-control-sm example">-->
                  <textarea class="form-control" name="motivo" id="motivo" rows="3"></textarea>
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-danger">Confirmar</button>
              </div>
            </form>
        </div>
        </div>
    </div>
@endsection
