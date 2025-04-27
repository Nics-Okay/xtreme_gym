<form method="post" action="{{ route('profileNew.updatePassword') }}">
@csrf
@method('put')

<div class="form-full">
    <label for="update_password_current_password">Current Password</label>
    <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password">
    @if ($errors->updatePassword->has('current_password'))
        <div>
            <strong>{{ $errors->updatePassword->first('current_password') }}</strong>
        </div>
    @endif
</div>

<div class="form-full">
    <label for="update_password_password">New Password</label>
    <input id="update_password_password" name="password" type="password" autocomplete="new-password">
    @if ($errors->updatePassword->has('password'))
        <div>
            <strong>{{ $errors->updatePassword->first('password') }}</strong>
        </div>
    @endif
</div>

<div class="form-full">
    <label for="update_password_password_confirmation">Confirm Password</label>
    <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
    @if ($errors->updatePassword->has('password_confirmation'))
        <div>
            <strong>{{ $errors->updatePassword->first('password_confirmation') }}</strong>
        </div>
    @endif
</div>

<div>
    <button type="submit" class="save-button">Save</button>
    @if (session('status') === 'password-updated')
        <p>Saved.</p>
    @endif
</div>
</form>