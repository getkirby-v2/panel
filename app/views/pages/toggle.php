<style>
.position-list {
  margin: 0 !important;
}
.position-list li {
  position: relative;
  list-style: none;
  padding: 0 .5rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.position-list-input input {
  cursor: pointer;
}
.position-list-input label {
  position: relative;
  display: block;
  cursor: pointer;
  padding: 5px 0;
}
.position-list-input label:before {
  position: absolute;
  left: 1.5em;
  top: 50%;
  content: "";
  margin-top: -5px;
  border-top: 5px solid transparent;
  border-right: 5px solid #dedede;
  border-bottom: 5px solid transparent;
  pointer-events: none;
}
.position-list-input:hover label:before {
  border-right-color: #000;
}
.position-list-input label:after {
  position: absolute;
  content: "";
  left: 1.5em;
  right: 1em;
  height: 2px;
  background: #dedede;
  top: 50%;
  margin-top: -0.5px;
  pointer-events: none;
}
.position-list-input:hover label:after {
  background: #000;
}
.position-list-label small {
  font-size: .7em;
  color: #999;
  display: inline-block;
  width: 1.5rem;
}
</style>
<div class="modal-content">
  <?php echo $form ?>
</div>