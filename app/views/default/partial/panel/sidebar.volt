<ul class="navbar-nav sidebar sidebar-dark accordion sakura-bg <?=(!empty($_COOKIE['sidebar-collapse']) and $_COOKIE['sidebar-collapse'] === 'hide') ? 'toggled':'' ?>" id="accordionSidebar">

    <div class="sakura-bgx">
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" target="_blank" href="{{url('./')}}">
        <div class="sidebar-brand-icon sakura-icolor" >
            <i class="fas fa-leaf"></i>
          </div>
        <div class="sidebar-brand-text mx-2">{{ site.get('app-name', getenv('APP_NAME') ? getenv('APP_NAME') : 'Sakura Panel') }}</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0 pb-3">

      {% set menu = page.getMenu() %}
      {% if menu | length %}
        {% for k,m in menu %}
          {% if m['items'] is defined and m['items'] | length %}
            <div class="sidebar-heading pt-3 mt-3">
              {{ k }}
            </div>
            {% for it in m['items'] %}
              {% if it['sub'] is defined and it['sub'] | length %}
                <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse{{ loop.index }}" aria-expanded="true" aria-controls="collapse{{ loop.index }}">
                    <i class="fas fa-fw fa-{{ it['icon'] }}"></i>
                    <span>{{ it['title'] | e}}</span>
                  </a>
                  <div id="collapse{{ loop.index }}" class="collapse" aria-labelledby="{{ it['title'] | e }}" data-parent="#accordionSidebar">
                    <div class="bg-sakura py-2 mt-3 collapse-inner ">
                      <h6 class="collapse-header">Sub Menu</h6>
                      {% for sm in it['sub'] %}
                        <a class="collapse-item" href="{{ sm['url'] | e }}">{% if sm['icon'] is defined %}<i class="fa-fw {{ sm['icon'] | e }}"></i>{% endif %} {{ sm['title'] | e }}</a>
                      {% endfor %}
                    </div>
                  </div>
                </li>
              {% else %}
              <li class="nav-item <?=(strpos(@$_GET['_url'] ?: 'url', (!empty($it['url']) ? $it['url'] : 'unknown')) > -1) ? 'active':''; ?>">
                  <a class="nav-link" {% if it['url'] is defined %}href="{{ url(it['url']) }}"{% endif %} {% if it['attrs'] is defined %}{{ it['attrs'] }}{% endif %}>
                    <i class="{{ it['icon'] }} fa-fw"></i>
                    <span>{{ it['title'] | e }}</span>
                  </a>
                </li>
              {% endif %}
            {% endfor %}
          {% endif %}
        {% endfor %}
      {% endif %}

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block mt-3">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </div>

</ul>