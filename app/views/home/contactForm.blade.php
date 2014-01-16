    <!-- contact -->
    <section id="contact" class="box">
        <div class="container">
            <div class="panel">
                <div class="row-fluid">
                    <div class="span12 header">
                        <hgroup>
                            <h2>{{'Contact'}}</h2>
                            <h3></h3>
                        </hgroup>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12 content">
                        <div class="row-fluid">
                            <div class="span6">
                                <h2 class="big-h2-heading"><i  class="fa fa-map-marker"></i> {{'Find Me'}}</h2>
                                <ul>
                                    <li><i  class="fa fa-building"></i> Rua Professor Quintino do Vale, 26 / 205</li>
                                    <li><i  class="fa-road"></i> Rio de Janeiro - Brasil - 20.250-030</li>
                                </ul>                               
                                <p><i  class="fa fa-phone"></i> +55-21-9-8088-2233</p>                                
                                <p class="email"><i  class="fa fa-envelope"></i> <a href="mailto:&#097;&#099;&#114;&#064;&#097;&#110;&#116;&#111;&#110;&#105;&#111;&#099;&#097;&#114;&#108;&#111;&#115;&#114;&#105;&#098;&#101;&#105;&#114;&#111;&#046;&#099;&#111;&#109;">&#097;&#099;&#114;&#064;&#097;&#110;&#116;&#111;&#110;&#105;&#111;&#099;&#097;&#114;&#108;&#111;&#115;&#114;&#105;&#098;&#101;&#105;&#114;&#111;&#046;&#099;&#111;&#109;</a></p>
                                <!-- googlemaps -->
                                <div id="map_canvas"></div>
                            </div>
                            <div class="span6">
                                <h2 class="big-h2-heading"><i  class="fa fa-comment"></i> {{'Send Me a Message'}}</h2>
                                <div class="row-fluid">
                                    @if(isset($messages))
                                        @foreach($messages as $message)
                                            <div class="alert alert-danger">{{ g($message) }}</div>
                                        @endforeach
                                    @endif
                                </div>
                                {{ Form::open(['url' => URL::route('contact.send')]) }}
                                    <div class="form-group has-success">
                                        {{ Form::text('name', null, ['placeholder' => g('Your Name'), 'class' => 'span12' ]) }}

                                        {{ Form::text('email', null, ['placeholder' => g('Your E-mail'), 'class' => 'span12' ]) }}

                                        {{ Form::text('telephone', null, ['placeholder' => g('Your Telephone'), 'class' => 'span12' ]) }}

                                        {{ Form::text('subject', null, ['placeholder' => g('The Subject'), 'class' => 'span12' ]) }}

                                        {{ Form::textarea('message', null, ['placeholder' => g('Your Message Comes Here'), 'class' => 'span12', 'rows' => '9' ]) }}

                                        {{ Form::submit(g('Send Message'), ['class' => 'btn btn-default submit']) }}
                                    </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                        <br><br>
                        <div class="row-fluid black">
                            <h1 class="big-h2-heading text-center">
                                <a data-nav="scroll" title="Blog" href="{{ URL::to('/') }}/blog"><i class="fa fa-file-text-o"></i></a>
                                &nbsp;&nbsp;&nbsp;

                                <a data-nav="scroll" title="Github" href="http://github.com/antonioribeiro"><i class="fa fa-github"></i></a>

                                &nbsp;&nbsp;&nbsp;
                                
                                @if(Glottos::getLocaleAsText() == 'pt_BR')
                                    <a data-nav="scroll" title="Twitter" href="http://twitter.com/iantoniocarlos">
                                @else
                                    <a data-nav="scroll" title="Twitter" href="http://twitter.com/iantonioribeiro">
                                @endif
                                <i class="fa fa-twitter"></i>
                                </a>

                                &nbsp;&nbsp;&nbsp;

                                <a data-nav="scroll" title="Stack Overflow" href="http://stackoverflow.com/users/1959747/antonio-carlos-ribeiro"><i class="fa fa-stack-overflow"></i>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
