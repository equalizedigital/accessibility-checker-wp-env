#Setup port mapping so dev server can make loopback calls.
npx wp-env run wordpress sudo apt install iptables -y
npx wp-env run wordpress sudo iptables -t nat -A OUTPUT -o lo -p tcp --dport 8888 -j REDIRECT --to-port 80

#Setup port mapping so tests server can make loopback calls.
npx wp-env run tests-wordpress sudo apt install iptables -y
npx wp-env run tests-wordpress sudo iptables -t nat -A OUTPUT -o lo -p tcp --dport 8889 -j REDIRECT --to-port 80

#source the .env file
env_file=".env"
if [ -f "$env_file" ]; then
    source "$env_file"
    npx wp-env run cli wp option update edacp_license_key $LICENSE
    npx wp-env run tests-cli wp option update edacp_license_key $LICENSE
fi

#setup auth username/password
npx wp-env run cli wp option update edacp_authorization_username admin
npx wp-env run cli wp option update edacp_authorization_password password
npx wp-env run tests-cli wp option update edacp_authorization_username admin
npx wp-env run tests-cli wp option update edacp_authorization_password password

#activate AC plugins on dev
npx wp-env run cli wp plugin activate accessibility-checker
npx wp-env run cli wp plugin activate accessibility-checker-pro
npx wp-env run cli wp plugin activate accessibility-checker-audit-history

#install dev plugins on dev
npx wp-env run cli wp plugin install query-monitor --activate
npx wp-env run cli wp plugin install jsm-show-user-meta --activate
npx wp-env run cli wp plugin install jsm-show-user-meta --activate
npx wp-env run cli wp plugin install transients-manager --activate
npx wp-env run cli wp plugin install wp-crontrol --activate


#deactivate AC plugins on tests so we have a clean slate
npx wp-env run tests-cli wp plugin deactivate accessibility-checker
npx wp-env run tests-cli wp plugin deactivate accessibility-checker-pro
npx wp-env run tests-cli wp plugin deactivate accessibility-checker-audit-history



# Add dummy content to dev instance
count=1
for ((i=1; i<=$count; i++)); do
    npx wp-env run cli wp post create --post_type='post' --post_title='Bad post' /mnt/a-bad-page.html
    npx wp-env run cli wp post create --post_type='page' --post_title='Bad page' /mnt/a-bad-page.html
done
npx wp-env run cli wp post generate --post_type=page --count=5
npx wp-env run cli wp post generate --post_type=post --count=100



