<?php
return function () use ($templates) {
  return $templates->render(withVariant('not-found'), []);
};
