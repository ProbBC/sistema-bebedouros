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
                <a class="nav-link active" aria-current="page" href="{{ route ('bebedouros.index') }}">Bebedouros</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="{{ route ('solicitacoes.index') }}">Solicitações de troca</a>
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
    <!--conteudo do bebedouro-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p2 mt-5">
                <div class="row">
                    <div class="col-6 d-flex justify-content-center">
                        <h5>Adicionar bebedouro</h5>
                    </div>
                    <div class="col-6 d-flex justify-content-center">
                        <button type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal5">Adicionar bebedouro</button>
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
                            <th scope="col">Descrição</th>
                            <th scope="col">Bloco</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                          @foreach ($bebedouros as $bebedouro)
                            <tr>
                            <th scope="row"><span>{{ $bebedouro->desc }}</span></th>
                            <td>{{ $bebedouro->bloco->desc }}</td>
                            <td><i class="fas fa-edit edit-item" data-id="{{ $bebedouro->id }}" data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
                              <i class="fas fa-trash mx-2 delete-item" data-id="{{ $bebedouro->id }}" data-bs-toggle="modal" data-bs-target="#exampleModa3"></i></td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @php
          $itens = $bebedouros;
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
          $('#bebedouro_id').val(dataID);
          $('#exampleModal').modal('show');
          $('#edit-form').attr('action', "{{ route('bebedouros.update', '') }}/" + dataID);
      });
    </script>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar bebedouro</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="edit-form" method="POST">
                  @csrf
                  @method('PUT')
              <div class="modal-body">
                  <span>Bloco</span>
                  <select class="form-select form-select-sm mb-2" name="bloco_id" aria-label=".form-select-sm example">
                    <option value="" disabled selected hidden>Bloco</option>
                    @foreach ($blocos as $bloco)
                        <option value="{{ $bloco->id }}">{{ $bloco->desc }}</option>
                    @endforeach
                  </select>
                  <span>Descrição</span>
                  <input class="form-control form-control-sm" name="desc" type="text" aria-label=".form-control-sm example">
              </div>
              <div class="modal-footer">
              <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Fechar</button>
              <button type="submit" class="btn btn-danger">Confirmar</button>
              </div>
            </form>
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
              <form action="{{ route('bebedouros.destroy')}}" method="POST">
                    @csrf
                    @method('DELETE')
                <input type="hidden", name="bebedouro_id" id="bebedouro_id">
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
          $('#bebedouro_id').val(dataID);
          $('#exampleModal3').modal('show');
      });
    </script>

    <!--modal botao adicionar bebedouro-->
    <div class="modal fade" id="exampleModa4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Atender solicitação</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <span>Bebedouro</span>
                        <input class="form-control" type="text" placeholder="Bebedouro 3" aria-label="Disabled input example" disabled>
                    </div>
                    <div class="col-6">
                        <span>Motivo</span>
                        <p class="form-control " type="text" aria-label="Disabled input example" disabled>asdasdasdasd asdasd asdasdasd asdasd asdasd asdasd adas </p>
                    </div>
                </div>

                <span>Comentarios</span>
                <input class="form-control form-control-sm" type="text" aria-label=".form-control-sm example">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-danger">Realizar troca</button>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal botao adicionar bebedouro-->
    <div class="modal fade" id="exampleModal5" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Adicionar bebedouro</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('bebedouros.store') }}" method="POST" >
              @csrf
              <div class="modal-body">
                  <span>Bloco</span>
                  <select class="form-select form-select-sm mb-2" name="bloco_id" aria-label=".form-select-sm example">
                    @foreach ($blocos as $bloco)
                        <option value="{{ $bloco->id }}">{{ $bloco->desc }}</option>
                    @endforeach
                  </select>
                  <span>Descrição</span>
                  <input class="form-control form-control-sm" name="desc" type="text" aria-label=".form-control-sm example">
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
