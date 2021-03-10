<div id="login-page" class="login-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <section id="content" >
                    <?php if(isset($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <?php echo form_open(); ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>"maxLength="50" required>
                            <?php echo form_error('email'); ?>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>" maxLength="50" required>
                            <?php echo form_error('password'); ?>
                        </div>                    
                        <?php if(isset($login_referrer)): ?>
                            <input type="hidden" id="referrer" name="referrer" value="<?php echo $login_referrer; ?>">
                        <?php endif; ?>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>