
@if(!empty($domainForEmail))
    <option value="{{ 'admin@' . $domainForEmail }}" {{ old('ssl_confirmation_email') == 'admin@' . $domainForEmail ? 'selected' : '' }} id="admin_email">{{ 'admin@' . $domainForEmail }}</option>
    <option value="{{ 'administrator@' . $domainForEmail }}" {{ old('ssl_confirmation_email') == 'administrator@' . $domainForEmail ? 'selected' : '' }} id="administrator_email">{{ 'administrator@' . $domainForEmail }}</option>
    <option value="{{ 'hostmaster@' . $domainForEmail }}" {{ old('ssl_confirmation_email') == 'hostmaster@' . $domainForEmail ? 'selected' : '' }} id="hostmaster_email">{{ 'hostmaster@' . $domainForEmail }}</option>
    <option value="{{ 'webmaster@' . $domainForEmail }}" {{ old('ssl_confirmation_email') == 'webmaster@' . $domainForEmail ? 'selected' : '' }} id="webmaster_email">{{ 'webmaster@' . $domainForEmail }}</option>
    <option value="{{ 'postmaster@' . $domainForEmail }}" {{ old('ssl_confirmation_email') == 'postmaster@' . $domainForEmail ? 'selected' : '' }} id="postmaster_email">{{ 'postmaster@' . $domainForEmail }}</option>
@endif

@if(!empty($subdomainForEmail))
    <option value="{{ 'admin@' . $subdomainForEmail }}" {{ old('ssl_confirmation_email') == 'admin@' . $subdomainForEmail ? 'selected' : '' }} id="admin_email_subdomain">{{ 'admin@' . $subdomainForEmail }}</option>
    <option value="{{ 'administrator@' . $subdomainForEmail }}" {{ old('ssl_confirmation_email') == 'administrator@' . $subdomainForEmail ? 'selected' : '' }} id="administrator_email_subdomain">{{ 'administrator@' . $subdomainForEmail }}</option>
    <option value="{{ 'hostmaster@' . $subdomainForEmail }}" {{ old('ssl_confirmation_email') == 'hostmaster@' . $subdomainForEmail ? 'selected' : '' }} id="hostmaster_email_subdomain">{{ 'hostmaster@' . $subdomainForEmail }}</option>
    <option value="{{ 'webmaster@' . $subdomainForEmail }}" {{ old('ssl_confirmation_email') == 'webmaster@' . $subdomainForEmail ? 'selected' : '' }} id="webmaster_email_subdomain">{{ 'webmaster@' . $subdomainForEmail }}</option>
    <option value="{{ 'postmaster@' . $subdomainForEmail }}" {{ old('ssl_confirmation_email') == 'postmaster@' . $subdomainForEmail ? 'selected' : '' }} id="postmaster_email_subdomain">{{ 'postmaster@' . $subdomainForEmail }}</option>
@endif