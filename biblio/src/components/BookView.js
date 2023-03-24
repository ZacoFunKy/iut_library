function BookView({Book}) {

  console.log(Book);

  return (
    <div className="book">
      <div className="book__title">{Book.volumeInfo.title}</div>
    </div>
  );
}

export default BookView;