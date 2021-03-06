@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">

		<section class="col-md-3">
			<div class="card">

				<div class="list-group">
					<a href="#" class="list-group-item list-group-item-action active">
							{{ __('General Settings') }}
					</a>

					<a href="#" class="list-group-item list-group-item-action">
						Morbi leo risus
					</a>
					<a href="#" class="list-group-item list-group-item-action">
						Porta ac consectetur ac
					</a>
				</div>

			</div>
		</section>

		<div class="col-md-9">
			<div class="card">
				<div class="card-header">
					{{ __('General Settings') }}
				</div>

				<div class="card-body">
					
					@include('components/session-alerts/success')
					@include('components/session-alerts/error')

					<table class="table">
						<tbody>
							<tr>
								<th scope="row">
									Avatar
								</th>
								<td>
									@if ($user['avatar']['icon'])
										<img src="{{ Storage::url('img/u/'. $user['id']. '/avatars/'. $user['avatar']['icon'] ) }}"
											class="img-fluid rounded-circle" width="55px" alt="{{$user['username']}}">
									@else
										<img src="{{ Storage::url('img/u/default/avatars/48.png' ) }}"
											class="img-fluid rounded-circle" width="48px" alt="{{$user['username']}}">
									@endif									
								</td>
								<td>
									<button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
										data-target="#modalUpdateAvatar">
										{{ __('Edit') }}
									</button>
								</td>
							</tr>
							<tr>
								<th scope="row">
									Name
								</th>
								<td>
									{{ $user['name'] }}
								</td>
								<td>
									<button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
										data-target="#modalUpdateName">
										{{ __('Edit') }}
									</button>
								</td>
							</tr>
							<tr>
								<th scope="row">
									Username
								</th>
								<td>
									{{ $user['username'] }}
								</td>
								<td>
									<button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
										data-target="#modalUpdateUsername">
										{{ __('Edit') }}
									</button>
								</td>
							</tr>
							<tr>
								<th scope="row">
									Email
								</th>
								<td>
									{{ $user['email'] }}
								</td>
								<td>
									<button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
										data-target="#modalUpdateEmail">
										{{ __('Edit') }}
									</button>
								</td>
							</tr>
							<tr>
								<th scope="row">
									{{ __('Language') }}
								</th>
								<td>
									{{ __('lang_'.$g_user->lang) }}
								</td>
								<td>
									<button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
										data-target="#modalUpdateLang">
										{{ __('Edit') }}
									</button>
								</td>
							</tr>
							<tr>
								<th scope="row">
									Password
								</th>
								<td>
									********
								</td>
								<td>
									<button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
										data-target="#modalUpdateNewPassword">
										{{ __('Edit') }}
									</button>
								</td>
							</tr>

						</tbody>
					</table>

					<!-- Modals Update -->
					<!-- #/modalUpdateAvatar -->
					<div class="modal fade" id="modalUpdateAvatar" tabindex="-1" role="dialog" aria-labelledby="modalUpdateAvatar"
						aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">

							<form class="modal-content" method="POST" action="{{ route('settings.avatarUpload',$user['id']) }}"
								enctype="multipart/form-data">
								@csrf
								@method('PUT')
								<div class="modal-header">
									<h5 class="modal-title">
										{{ __('Edit') }}
									</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<label for="avatar" class="col-md-3 col-form-label">{{ __('Avatar') }}</label>

										<div class="col-md-9">

											<input type="file" class="form-control 
											@error('avatar') is-invalid @enderror" name="avatar" required autofocus>

											@error('avatar')
											<span class="invalid-feedback" role="alert">
												<strong>
													$message	{{ __( $message ) }}
												</strong>
											</span>
											@enderror
										</div>

									</div>

								</div>
								<div class="modal-footer">
									@if ($user['avatar'])
										<a class="btn btn-danger" href="{{ route('settings.avatarDelete',$user['id']) }}"
												onclick="event.preventDefault();
												document.getElementById('form-avatarDelete').submit();">
								 			{{ __('Delete') }}
								 		</a>
									@endif
									<button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">
										{{ __('Cancel') }}
									</button>
								</div>
							</form>

							<form id="form-avatarDelete" class="d-none"
										action="{{ route('settings.avatarDelete',$user['id']) }}" method="POST">
								@csrf
								@method('PUT')
							</form>

						</div>
					</div>
					<!-- #/modalUpdateAvatar -->

					<!-- #/modalUpdateLang -->
					<div class="modal fade" id="modalUpdateLang" tabindex="-1" role="dialog" aria-labelledby="modalUpdateLang"
						aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">

							<form class="modal-content" method="POST" action="{{ route('settings.changeLang',$user['id']) }}">
								@csrf
								@method('PUT')
								<div class="modal-header">
									<h5 class="modal-title">
										{{ __('Edit') }}
									</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<label for="lang" class="col-md-3 col-form-label">{{ __('Language') }}</label>

										<div class="col-md-9">

											<select class="custom-select @error('lang') is-invalid @enderror"
															 name="lang" id="lang" required autofocus>
												<option disabled>Select Language</option>

												<!-- $langs on AppServiceProvider -->
												@foreach ($langs as $key => $value)
													<option value="{{ $value }}" {{ ( $value == $g_user->lang) ? 'selected' : '' }}> 
														{{ __('lang_'. $value ) }} 
													</option>
												@endforeach
												
											</select>

											@error('lang')
											<span class="invalid-feedback" role="alert">
												<strong>
													$message
													{{ __( $message ) }}
												</strong>
											</span>
											@enderror
										</div>

									</div>

								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">
										{{ __('Cancel') }}
									</button>
								</div>
							</form>

						</div>
					</div>
					<!-- #/modalUpdateLang -->

					<!-- #/modalUpdateName -->
					<div class="modal fade" id="modalUpdateName" tabindex="-1" role="dialog"
						aria-labelledby="modalUpdateNameTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">

							<form class="modal-content" method="POST" action="{{ route('settings.update',$user['id']) }}">
								@csrf
								@method('PUT')
								<div class="modal-header">
									<h5 class="modal-title" id="modalUpdateNameTitle">
										{{ __('Edit') }}
									</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<label for="name" class="col-md-4 col-form-label">{{ __('Name') }}</label>

										<div class="col-md-6">
											<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
												value="{{ $user['name'] }}" required autofocus autocomplete="off">

											@error('name')
											<span class="invalid-feedback" role="alert">
												<strong> {{ __($message) }} </strong>
											</span>
											@enderror
										</div>
									</div>

									<div class="form-group row">
										<label for="password" class="col-md-4 col-form-label">{{ __('Password') }}</label>

										<div class="col-md-6">
											<input type="password" class="form-control @error('password') is-invalid @enderror"
												name="password" value="" required autofocus autocomplete="off">

											@error('password')
											<span class="invalid-feedback" role="alert">
												<strong> {{ __($message) }} </strong>
											</span>
											@enderror
										</div>
									</div>

								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">
										{{ __('Cancel') }}
									</button>
								</div>
							</form>
						</div>
					</div>
					<!-- #/modalUpdateName -->

					<!-- #/modalUpdateUsername -->
					<div class="modal fade" id="modalUpdateUsername" tabindex="-1" role="dialog"
						aria-labelledby="modalUpdateNameTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">

							<form class="modal-content" method="POST" action="{{ route('settings.update',$user['id']) }}">
								@csrf
								@method('PUT')
								<div class="modal-header">
									<h5 class="modal-title">
										{{ __('Edit') }}
									</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<label for="username" class="col-md-4 col-form-label">{{ __('Username') }}</label>

										<div class="col-md-6">
											<input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
												name="username" value="{{ $user['username'] }}" required autofocus autocomplete="off">

											@error('username')
											<span class="invalid-feedback" role="alert">
												<strong>
													{{ __($message) }}
												</strong>
											</span>
											@enderror
										</div>
									</div>

									<div class="form-group row">
										<label for="password" class="col-md-4 col-form-label">{{ __('Password') }}</label>

										<div class="col-md-6">
											<input type="password" class="form-control @error('password') is-invalid @enderror"
												name="password" value="" required autofocus autocomplete="off">

											@error('password')
											<span class="invalid-feedback" role="alert">
												<strong>{{ __($message) }}</strong>
											</span>
											@enderror
										</div>
									</div>

								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">
										{{ __('Cancel') }}
									</button>
								</div>
							</form>
						</div>
					</div>
					<!-- #/modalUpdateUsername -->

					<!-- #/modalUpdateEmail -->
					<div class="modal fade" id="modalUpdateEmail" tabindex="-1" role="dialog"
						aria-labelledby="modalUpdateNameTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">

							<form class="modal-content" method="POST" action="{{ route('settings.update',$user['id']) }}">
								@csrf
								@method('PUT')
								<div class="modal-header">
									<h5 class="modal-title">
										{{ __('Edit') }}
									</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<label for="email" class="col-md-4 col-form-label">{{ __('Email') }}</label>

										<div class="col-md-6">
											<input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
												name="email" value="{{ old($user['email']) }}" required autofocus autocomplete="email">

											@error('email')
											<span class="invalid-feedback" role="alert">
												<strong> {{ __($message) }} </strong>
											</span>
											@enderror
										</div>
									</div>

									<div class="form-group row">
										<label for="password" class="col-md-4 col-form-label">{{ __('Password') }}</label>

										<div class="col-md-6">
											<input type="password" class="form-control @error('password') is-invalid @enderror"
												name="password" value="" required autofocus autocomplete="off">

											@error('password')
											<span class="invalid-feedback" role="alert">
												<strong> {{ __($message) }} </strong>
											</span>
											@enderror
										</div>
									</div>

								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">
										{{ __('Cancel') }}
									</button>
								</div>
							</form>
						</div>
					</div>
					<!-- #/modalUpdateEmail -->

					<!-- #/modalUpdateNewPassword -->
					<div class="modal fade" id="modalUpdateNewPassword" tabindex="-1" role="dialog"
						aria-labelledby="modalUpdateNameTitle" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">

							<form class="modal-content" method="POST" action="{{ route('settings.update',$user['id']) }}">
								@csrf
								@method('PUT')
								<div class="modal-header">
									<h5 class="modal-title">
										{{ __('Edit') }}
									</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<label for="new_password" class="col-md-4 col-form-label">{{ __('New Password') }}</label>

										<div class="col-md-6">
											<input id="new_password" type="password"
												class="form-control @error('new_password') is-invalid @enderror" name="new_password"
												value="{{ $user['new_password'] }}" required autofocus autocomplete="off">

											@error('new_password')
											<span class="invalid-feedback" role="alert">
												<strong> {{ __($message) }} </strong>
											</span>
											@enderror
										</div>
									</div>

									<div class="form-group row">
										<label for="password" class="col-md-4 col-form-label">{{ __('Current password') }}</label>

										<div class="col-md-6">
											<input type="password" class="form-control @error('password') is-invalid @enderror"
												name="password" value="" required autofocus autocomplete="off">

											@error('password')
											<span class="invalid-feedback" role="alert">
												<strong> {{ __($message) }} </strong>
											</span>
											@enderror
										</div>
									</div>

								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">
										{{ __('Cancel') }}
									</button>
								</div>
							</form>
						</div>
					</div>
					<!-- #/modalUpdateNewPassword -->

				</div>
			</div>
		</div>
	</div>
</div>
@endsection