import { DataTable } from "mantine-datatable";
import { NumberingSchemeResourceData } from "../Types/NumberingSchemeResourceData";

interface NumberingSchemeTableProps {
    records: NumberingSchemeResourceData[];
    totalRecords: number;
    recordsPerPage: number;
    page: number;
    onPageChange: (page: number) => void;
    selectedRecords: NumberingSchemeResourceData[];
    onSelectedRecordsChange: (records: NumberingSchemeResourceData[]) => void;
}

const NumberingSchemeTable: React.FC<NumberingSchemeTableProps> = ({
    records,
    totalRecords,
    recordsPerPage,
    page,
    onPageChange,
    selectedRecords,
    onSelectedRecordsChange,
}) => {
    return (
        <DataTable
            pinLastColumn
            withTableBorder
            shadow="xs"
            borderRadius="sm"
            withRowBorders={false}
            highlightOnHover
            verticalSpacing="md"
            totalRecords={totalRecords}
            recordsPerPage={recordsPerPage}
            page={page}
            onPageChange={onPageChange}
            columns={[
                { accessor: "name", title: "Name", noWrap: true },
                { accessor: "description", title: "Description", noWrap: true },
                { accessor: "folder", title: "Folder", noWrap: true },
            ]}
            records={records}
            selectedRecords={selectedRecords}
            onSelectedRecordsChange={onSelectedRecordsChange}
        />
    );
};

export default NumberingSchemeTable;