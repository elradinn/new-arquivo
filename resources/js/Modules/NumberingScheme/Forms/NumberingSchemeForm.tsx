import { Modal, Text, TextInput, Button, Stack, Flex } from "@mantine/core";
import { NumberingSchemeResourceData } from "../Types/NumberingSchemeResourceData";
import { useUpdateNumberingScheme } from "../Hooks/use-update-numbering-scheme";
interface NumberingSchemeFormProps {
    isOpened: boolean;
    close: () => void;
    initialData?: NumberingSchemeResourceData;
}

const NumberingSchemeForm: React.FC<NumberingSchemeFormProps> = ({
    isOpened,
    close,
    initialData,
}) => {
    const { data, setData, handleSubmit, processing, errors } = useUpdateNumberingScheme({
        initialData,
        close,
    });

    return (
        <Modal
            opened={isOpened}
            onClose={close}
            title={<Text size="lg">{initialData ? "Edit" : "Create"} Numbering Scheme</Text>}
            size={550}
        >
            <form onSubmit={handleSubmit}>
                <Stack gap={16}>
                    <TextInput
                        label="Name"
                        value={data.name}
                        onChange={(e) => setData("name", e.target.value)}
                        error={errors.name}
                        required
                    />
                    <TextInput
                        label="Prefix"
                        value={data.prefix}
                        onChange={(e) => setData("prefix", e.target.value)}
                        error={errors.prefix}
                        required
                    />
                </Stack>
                <Flex align="center" justify="end" mt={16}>
                    <Button variant="outline" onClick={close}>
                        Cancel
                    </Button>
                    <Button ml={12} type="submit" loading={processing}>
                        {initialData ? "Update" : "Create"}
                    </Button>
                </Flex>
            </form>
        </Modal>
    );
};

export default NumberingSchemeForm;