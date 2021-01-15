<div id="login-page" class="login-page">
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <section id="content" >
                    <?php if(isset($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    <?php echo form_open(); ?>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" maxLength="50" required>
                            <?php echo form_error('username'); ?>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" maxLength="50" required>
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
            <div class="col-md-4"></div>
        </div>
    </div>
</div>